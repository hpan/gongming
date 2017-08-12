@extends('layouts.admin')
@section('title', '市政爆料管理系统')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 10px 10px;">爆料管理</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    {{--<a href="{{ url('admin/article/create') }}" class="btn btn-lg btn-primary">新增</a>--}}

                    @foreach ($articles as $article)
                        <hr>
                        <div class="article">
                            <h6>
                                <span>[{{$article->id}}]</span>
                                <span><b>爆料人姓名：</b></span><span>
                            @if($article->anonymous == 1)
                                        匿名
                                    @else
                                        {{$article->name}}
                                    @endif
                            </span>&nbsp;
                                <span><b>手机号：</b></span><span>{{$article->mobile}}</span>&nbsp;
                                <span><b>地址：</b></span><span>{{$article->address}}</span>&nbsp;
                                <span><b>爆料时间：</b></span><span>{{$article->created_at}}</span>&nbsp;
                                <span style="display:none;"><b>openId：</b></span><span style="display:none;">{{$article->wechat_open_id}}</span>&nbsp;


                            </h6>
                            <div class="content">
                                {{ $article->body }}
                                <?php
                                    $imgArray = explode(",", $article->images);
//                                    var_dump($imgArray);
                                ?>
                                <div style="width: 100%; height: 75px;">
                                    @foreach($imgArray as $img)
                                        @if(strlen($img)>0)
                                            <a href="{{$img}}" rel="lightbox-{{$article->id}}}}"><img src="{{$img}}" class="cover_small"></a>
                                        @else
                                            {{--<div class="cover_small" style="background-color: #2e3436; float:left;"></div>--}}
                                        @endif
                                    @endforeach
                                <form action="{{ url('admin/article/'.$article->id) }}" method="POST" style="display: inline; float:right; padding: 20px 10px;">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger">删除</button>
                                    @if($article->status == 1)
                                        <a data-toggle="modal" data-target="#feedback" class="btn btn-default btn-large btn-feedback" data="{{$article->id}}">已回复</a>
                                    @else
                                        <a data-toggle="modal" data-target="#feedback" class="btn btn-primary btn-large btn-feedback" data="{{$article->id}}">回复</a>
                                    @endif

                                </form>
                                    {{--<div style="width:80px;height: 60px; float:right; background-color: #2ca02c;">P</div>--}}
                                </div>
                            </div>
                        </div>
                        {{--<a href="{{ url('admin/article/'.$article->id.'/edit') }}" class="btn btn-success">编辑</a>--}}
                        <div style="font-size:9pt; color: #999;">
                        </div>

                    @endforeach
                </div>
            </div>
            <div style="width:100%; text-align:center; margin-top: -30px;">{!! $articles->links() !!}</div>

            <div class="modal fade" id="feedback">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ url('admin/comment') }}" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    ×
                                </button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    {{--<label for="new_folder_name" class="col-sm-3 control-label">--}}
                                    {{--Folder Name--}}
                                    {{--</label>--}}
                                    <div class="col-sm-11">
                                        <input type="hidden" name="article_id" value="0">
                                        <input type="hidden" name="nickname" value="admin">
                                        <textarea name="content" id="content" placeholder="您的爆料已收到,十分感谢!" class="form-control" maxlength="140" rows="4" ></textarea>

                                        {{--<input type="text" id="content" name="new_folder" class="form-control">--}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    取消
                                </button>
                                <button type="submit" class="btn btn-primary" id="fbSubmit">
                                    回复
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $(function(){
            $(".btn-feedback").click(
                    function(){
                        var articleId = $(this).attr("data");
                        $("input[name=article_id]").val(articleId);
                        $.get("/admin/comment/" + articleId, function(res){
                                    if(res!=undefined && res !="" && res!=null) {
                                        $("textarea[name=content]").val(res[0].content);
                                        $("textarea[name=content]").attr('disabled', true);
                                        $("#fbSubmit").addClass("hide");
                                    }else{
                                        $("textarea[name=content]").val('');
                                        $("textarea[name=content]").attr('disabled', false);
                                        $("#fbSubmit").removeClass("hide");
                                    }
                        })
                    }
            )
        })
    </script>
@endsection
