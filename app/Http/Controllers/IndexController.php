<?php

namespace App\Http\Controllers;


use App\Sites;
use Log;
use App\Users;
use App\Http\Services\SiteParser;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use NicoVerbruggen\ImageGenerator\ImageGenerator;
use Mail;

class IndexController extends Controller
{
    use AuthenticatesUsers;

    //获取网站列表
    public function list(Request $request){
        $userId = $request->session()->get('user_id', 'default');
        $loginStatus = $request->session()->get('login_status', 1);

        $isPrivate = ($loginStatus == 2)?[0, 1]:[0];
        $keyWord = $request->input('key_word', '');
        $siteMp = Sites::where(['user_id' => $userId])->orderBy('updated_at', 'DESC');
        if(! empty($keyWord)){
            $siteMp->where('name' ,'like', "%{$keyWord}%");
        }
        $sites = $siteMp->whereIn('is_private', $isPrivate)->get();

        $result = [];

        foreach ($sites as $site){
            if(strpos($site->url, 'http') === false){
                $site->url = 'http://'.$site->url;
                $site->save();
            }

            $site->is_private = (bool) $site->is_private;

            $class = $site->class;
            $key = md5($class);
            if(empty($result[$key])){
                $result[$key] = ['class' => $class, 'list' => []];
            }
            $result[$key]['list'] []= $site->toArray();
        }
        return response()->json(array_values($result));
    }

    //保存网站
    public function save(Request $request){
        $userId = $request->session()->get('user_id', 'default');
        $url = $request->input('url');
        $id = $request->input('id', 0);
        if(empty($id)){
            $site = new Sites();
        }else{
            $site = Sites::find($id);
        }
        if(! empty($request->input('id'))){
            $site->id = $request->input('id');
        }
        $site->user_id = $userId;
        $site->url =  $url;
        $ico = $request->input('ico', '');
        $name = $request->input('name');
        if(empty($ico)){
            $ico = $this->generateSiteImage($name, $url);
        }
        $site->ico =$ico;
        $site->name = $request->input('name');
        $site->class = $request->input('class', '默认');
        $site->summary = $request->input('summary', ' ');
        $site->is_private = (int) $request->input('is_private', 0);
        $site->save();
        return response()->json(['status' => true]);
    }

    public function delete(Request $request){
        $id = $request->input('id', 0);
        if(empty($id)){
            abort(500, 'id error');
        }
        Sites::find($id)->delete();
        return response()->json(['status' => true]);
    }

    public function login(Request $request){
        $userStr = $request->input('user_id', 'default');
        $userArr = explode(':', $userStr);
        $userId = $userArr[0];
        $passwd = $userArr[1]??'';
        $user =  Users::where(['user_id' =>  $userId])->first();
        if(empty($user)){
            abort(400, 'user not exist');
        }
        if(empty($passwd)){
            $request->session()->put('user_id', $user->user_id);
            $request->session()->put('login_status', 1);
            return response()->json(['login_status' => 1, 'user_id' =>$userId]);
        }
        if($user->passwd != $passwd){
            abort(400, 'auth error');
        }
        $request->session()->put('user_id', $user->user_id);
        $request->session()->put('login_user', $user->user_id);   //支持别人的地址同步到自己而加上login_user 字段
        $request->session()->put('user', $user);
        $request->session()->put('login_status', 2);
        return response()->json(['login_status' => 2, 'user_id' =>$userId]);
    }

    //注册用户
    public function regist(Request $request){
        $userId = $request->input('user_id');
        $passwd = $request->input('passwd');
        if(strpos($userId, ':') !== false || strpos($passwd, ':') !== false){
            abort(400, '用户名不能含有:号');
        }
        $email = $request->input('email', '');
        $user =  Users::where(['user_id' =>  $userId])->first();
        if(! empty($user)){
            abort(400, 'user has exist');
        }
        $user = new Users();
        $user->user_id = $userId;
        $user->passwd = $passwd;
        $user->email =$email;
        $user->save();
        $request->session()->put('user_id', $user->user_id);
        $request->session()->put('user', $user);
        $request->session()->put('login_status', 2);
        return response()->json(['login_status' => 2, 'user_id' =>$userId]);
    }

    public function userInfo(Request $request){
        $userId = $request->session()->get('user_id', '');
        $loginStatus = $request->session()->get('login_status', 0);
        return response()->json(['login_status' => $loginStatus, 'user_id' =>$userId]);
    }

    public function logout(Request $request){
        $request->session()->flush();
        return response()->json(['status' => true]);
    }

    //生成网站信息
    public function sitegen(Request $request){
        $url = $request->input('url');
        $siteParse = new SiteParser();
        $info = $siteParse->getWebSiteInfo($url);
        return response()->json($info);
    }

    //计数 type 0 普通计数  1 点赞计数  2 不喜欢计数
    public function click(Request $request){
        $id = $request->input('id');
        $type = $request->input('type', 0);
        $site = Sites::find($id);
        switch ($type){
            case 0:
                $site->increment('total_click', 1);
                $userId = $request->session()->get('user_id', '');
                if($userId == $site->user_id){
                    $site->increment('click', 1);
                }
                break;
            case 1:
                $site->increment('up', 1);
                break;
            case 2:
                $site->increment('down', 1);
                break;
        }
        return response()->json(['status' => true]);
    }

    public function hotIds(){
        $users = Users::orderBy('updated_at', 'desc')->take(10)->get();
        $res = [];
        foreach ($users as $user){
            $res []= [
                'user_id' => $user->user_id,
                'label' => '默认'
            ];
        }
        return response()->json($res);
    }
    public function hotSites(){
        $sites = Sites::orderBy('up', 'desc')->where('is_private', '!=', '1')->take(10)->get();
        $res = [];
        foreach ($sites as $site){
            $res []= [
                'id' => $site->id,
                'url' => $site->url,
                'name' => $site->name,
                'class' => $site->class
            ];
        }
        return response()->json($res);
    }

    public function advise(Request $request){
        $msg = $request->input('text');
        $contact = $request->input('contact', 'null');
        $content = "联系人: {$contact} \n  留言: {$msg} \n";
        Log::info("留言通知".$content);
        Mail::raw($content, function ($message) {
            $message
                ->to('244541048@qq.com')
                ->subject('为简收藏留言通知');

        });
        return response()->json(['status' => true]);
    }

    //生成网站首字符的图片
    function generateSiteImage($title, $url){
        if(strpos($url, 'http') === false){
            $url = 'http://'.$url;
        }

        $urlArr = parse_url($url);
        if(empty($urlArr['host'])){
            return false;
        }
        $host = $urlArr['host'];
        // Create a new instance of ImageGenerator
        $generator = new ImageGenerator([
            // Decide on a target size for your image
            'targetSize' => '48x48',
            // Fun fact: if you set null for these, you'll get a random color for each generated placeholder!
            // You can also specify a specific hex color. ("#EEE" or "#EEEEEE" are both accepted)
            'textColorHex' => null,
            'backgroundColorHex' => null,
            // Let's point to a font. If it can't be found, it'll use a fallback (built-in to GD)
            'pathToFont' => "Kaiti.ttf",
            'fontSize' => 25
        ]);

        $char = mb_substr($title, 0, 1);
        $localIco =  "/service/navi/public/ico/".$host.'.png';
        $generator->makePlaceholderImage(
            $char, // The text that will be added to the image
            $localIco // The path where the image will be saved
        );
        return  '/ico/'.$host.'.png';
    }
}
