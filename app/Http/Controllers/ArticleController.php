<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;
use Log;

class ArticleController extends Controller
{
    public function show($id)
    {
        return view('article/show')->withArticle(Article::with('hasManyComments')->find($id));
    }

    public function create(){
//        Log::info('php create in...');
        return view('article/create');
    }

    public function store(Request $request) // Laravel 的依赖注入系统会自动初始化我们需要的 Request 类
    {
//        var_dump($request->get('anonymous')[0]);
//        return;
        // 数据验证
        $this->validate($request, [
//            'title' => 'required|unique:articles|max:255', // 必填、在 articles 表中唯一、最大长度 255
            'body' => 'required|max:500', // 必填
            'name' => 'max:10', //
            'mobile' => 'required|max:18', // 必填
            'address' => 'required|max:100', // 必填
        ],[
            'required'=>':attribute为必填项',//报错信息提醒
            'max'=>':attribute超过最大字数'
        ],[
            'body'=>"爆料内容",'name'=>"真实姓名",'mobile'=>"手机号",'address'=>"地址"
        ]);

        // 通过 Article Model 插入一条数据进 articles 表
        $article = new Article; // 初始化 Article 对象
        $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 article 的 title 属性
        $article->body = $request->get('body');
        $article->name = $request->get('name');
        $anonymous = 0;
        if(sizeof($request->get('anonymous'))>0 && $request->get('anonymous')[0] == "on")
        {
            $anonymous = 1;
        }
        $article->anonymous = $anonymous;
        $article->mobile = $request->get('mobile');
        $article->address = $request->get('address');
        $article->images = trim($request->get('iptImageUrls'), ","); // 同上
//        $article->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性

        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if ($article->save()) {
            return redirect('article/success'); // 保存成功，跳转到 文章管理 页
        } else {
            // 保存失败，跳回来路页面，保留用户的输入，并给出提示
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    public function success()
    {
        Log::info('php uploaddfdf in...');
        return view("article/success");
    }
}