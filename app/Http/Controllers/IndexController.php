<?php

namespace App\Http\Controllers;


use App\Sites;
use App\Users;
use App\Http\Services\SiteParser;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use NicoVerbruggen\ImageGenerator\ImageGenerator;

class IndexController extends Controller
{
    use AuthenticatesUsers;

    //获取网站列表
    public function list(Request $request){
        $userId = $request->session()->get('user_id', 'default');
        $keyWord = $request->input('key_word', '');
        if(empty($keyWord)){
            $sites = Sites::where(['user_id' => $userId])->orderBy('updated_at', 'DESC')->get();
        }else{
            $sites = Sites::where(['user_id' => $userId])
                ->where('name' ,'like', "%{$keyWord}%")->orderBy('updated_at', 'DESC')->get();
        }
        $result = [];

        foreach ($sites as $site){
            if(strpos($site->url, 'http') === false){
                $site->url = 'http://'.$site->url;
                $site->save();
            }
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
        $site->ico = $request->input('ico', 'example');
        $site->name = $request->input('name');
        $site->class = $request->input('class', '默认');
        $site->summary = $request->input('summary', ' ');
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
}
