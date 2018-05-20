<?php

namespace App\Http\Controllers;


use App\Sites;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class IndexController extends Controller
{
    use AuthenticatesUsers;

    //获取网站列表
    public function list(Request $request){
        $userId = $request->session()->get('user_id', 'default');
        $sites = Sites::where(['user_id' => $userId])->get();
        $result = [];

        foreach ($sites as $site){
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
//        die('fff');
        $request->session()->flush();
        return response()->json(['status' => true]);
    }

    //生成网站信息
    public function sitegen(Request $request){

        $url = $request->input('url');
        if(strpos($url, 'http') === false){
            $url = 'http://'.$url;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, ['User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36']);
        $resp = curl_exec($curl);
        curl_close($curl);

        if(strpos($url, 'http')){
            $url = 'http://'.$url;
        }
        $metaTags = get_meta_tags($url);
        $name = $this->getTitle($resp);
        $iconUrl = $this->parseFavicon($url);
        $resp = [
            'url' => $url,
            'name' => $metaTags['title']??$name,
            'class' => '',
            'summary' => $metaTags['description']??'',
            'keywords' => $metaTags['keywords']??'',
            'ico' => $iconUrl
        ];
        return response()->json($resp);
    }

    function parseFavicon($url) {
        $url =  $url.'/favicon.ico';
        if($this->is_working_url($url)){
            return $url;
        }else{
            $host = $this->url_to_domain($url);
            return 'http://cdn.website.h.qhimg.com/index.php?domain='.$host;
        }
    }

    function getTitle($html){
        $res = preg_match("/<title>(.*)<\/title>/siU", $html, $title_matches);
        if (!$res)
            return null;

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    }
    function url_to_domain($url)
    {
        $host = @parse_url($url, PHP_URL_HOST);
        // If the URL can't be parsed, use the original URL
        // Change to "return false" if you don't want that
        if (!$host)
            $host = $url;
        // The "www." prefix isn't really needed if you're just using
        // this to display the domain to the user
        if (substr($host, 0, 4) == "www.")
            $host = substr($host, 4);
        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50)
            $host = substr($host, 0, 47) . '...';
        return $host;
    }

    function is_working_url($url) {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_exec($handle);

        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }
        else {
            return false;
        }
    }
}
