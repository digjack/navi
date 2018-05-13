<?php

namespace App\Http\Controllers;


use App\Sites;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class IndexController extends Controller
{
    use AuthenticatesUsers;

    //获取网站列表
    public function list(Request $request){
        $userId = $request->input('user_id');
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
        $userId = 'banli';
        $site = new Sites();
        $site->user_id = $userId;
        $site->url = $request->input('url');
        $site->ico = $request->input('ico');
        $site->name = $request->input('name');
        $site->class = $request->input('class');
        $site->summary = $request->input('summary');
        $site->save();
        return response()->json(['status' => true]);
    }

    public function login(Request $request){

    }

    public function verify(Request $request){

    }

    public function logout(Request $request){

    }

    public function updateAccount(){

    }

}
