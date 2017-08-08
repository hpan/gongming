<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat\Message\Text;

class CommentController extends Controller
{
    public function index()
    {
        Log::info("comment index in...");
        echo "ccccccccccc";
    }
    //
    public function store(Request $request)
    {
        Log::info("comment store in...");
        if (Comment::create($request->all())) {
            $this->send();
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('评论发表失败！');
        }
    }


    public function send(){
        Log::info("comment send in...");
        $openId = "o_GGtv_8Op5YmNOm6dQBgal515zU";
        $app = app('wechat');
        $message = new Text(['content' => 'Hello world!']);
        $result = $app->staff->message($message)->to($openId)->send();
    }
}
