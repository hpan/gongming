<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;

use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use DB;
use EasyWeChat\Message\Text;

class CommentController extends Controller
{
    public function get($articleId)
    {
//        Log::info("comment get in...articleId = $articleId");
        $comments = DB::table("comments")->where('article_id', '=', $articleId)->orderBy('id', 'desc')->get();
//        Log::info(json_encode($comments));
        if(!empty($comments) && sizeof($comments) > 0){
            return $comments;
        }
        return "";
    }
    //
    public function store(Request $request)
    {
        Log::info("comment store in...");
        //1.保存回复内容
        if (Comment::create($request->all())) {
            //2.修改article表回复状态
            $article = Article::find($request->get("article_id"));
            $article->status = 1;
            $article->save();

            //3.微信给用户发消息
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
