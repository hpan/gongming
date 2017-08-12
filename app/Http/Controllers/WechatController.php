<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 2017/8/3
 * Time: 上午10:36
 */

namespace App\Http\Controllers;
use EasyWeChat\Staff\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use EasyWeChat\Message\Text;
use Log;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
//            $logMsg = "hello, " . $message->FromUserName . ", MsgType=" . $message->MsgType . "！";
            $logMsg = json_encode($message);
            $rtnMsg = "谢谢关注!";
            Log::info($logMsg);
            switch ($message->MsgType){
                case 'event':
                    Log::info("eventType = " . $message->Event);
                    switch ($message->Event){
                        case 'CLICK':
                            Log::info("get a click event");
                            break;
                        case 'VIEW';
                            Log::info("get a view event");
                            break;
                    }
                    break;

            }
            return $rtnMsg;
        });

//        $wechat->server->setEventHandler(function($event){
//
//        });

        Log::info('return response.');

        return $wechat->server->serve();
    }

    public function send(){
        $openId = "o_GGtv_8Op5YmNOm6dQBgal515zU";
        $app = app('wechat');
        $message = new Text(['content' => 'Hello world!']);
        $result = $app->staff->message($message)->to($openId)->send();
    }
    public function feedback(){
        $openId = "o_GGtv_8Op5YmNOm6dQBgal515zU";
        $app = app('wechat');
        $message = new Text(['content' => 'Hello world!']);
        $result = $app->staff->message($message)->to($openId)->send();
    }

    public function oauth_callback(){
        $app = app('wechat');
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        session(['wechat_user' => $user->toArray()]);

        Log::info("session.wechat_user = " . json_encode(session('wechat_user')));
//        Log::info('oauth_callback session.target_url = ' . session('target_url'));
        $targetUrl = empty(session('target_url')) ? '/' : session('target_url');

        header('location:'. $targetUrl); // 跳转到 user/profile
    }

    public function menu()
    {
        $app = app('wechat');
        $menu = $app->menu;

        $allMenus = $menu->all();
        $currentMenus = $menu->current();
        echo "allMenus=" . json_encode($allMenus);
        echo ",  currentMenus=" . json_encode($currentMenus);

    }

    public function createmenu(){
        Log::info('create menu in...');
        $buttons = [
            [
                "type" => "view",
                "name" => "工作动态",
                "url"  => "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzIxNTgxMTA2OA==#wechat_redirect"
            ],
            [
                "type" => "click",
                "name" => "随手拍",
                "key" => "ssp",
                "sub_button" =>[
                    [
                    "type" => "view",
                    "name" => "我要爆料",
                    "url"  => "http://gm.shenzhenjuly.com/article/create"
                    ]
                ]
            ]
            ,
        ];

        $app = app('wechat');
        $menu = $app->menu;
        $menu->add($buttons);
    }
}