<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 2017/8/3
 * Time: 上午10:36
 */

namespace App\Http\Controllers;


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
            return "欢迎关注 overtrue1111！";
        });

        Log::info('return response2222.');

        return $wechat->server->serve();
    }
}