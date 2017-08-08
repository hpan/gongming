<?php

namespace App\Http\Controllers\Admin;

use App\Article;
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
            $article = Article::find($request->get("article_id"));
            $this->send($article->wechat_open_id, $request->get("content"));
            return redirect()->back();
        } else {
            return redirect()->back()->withInput()->withErrors('评论发表失败！');
        }
    }


    public function send($openId, $content){
        Log::info("comment send in...");
//        $openId = "o_GGtv_8Op5YmNOm6dQBgal515zU";
        $app = app('wechat');
        $message = new Text(['content' => $content]);
        $result = $app->staff->message($message)->to($openId)->send();
    }
}
