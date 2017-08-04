<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 2017/8/3
 * Time: 上午10:36
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;

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
            return "hello, " . $message->FromUserName . ", MsgType=" . $message->MsgType . ", 欢迎来信！";
        });

        Log::info('return response2222.');

        return $wechat->server->serve();
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
                "type" => "view",
                "name" => "随手拍",
                "url"  => "http://gm.shenzhenjuly.com/article/create"
            ],
        ];

        $app = app('wechat');
        $menu = $app->menu;
        $menu->add($buttons);
    }
}