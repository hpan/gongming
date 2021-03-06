@extends('layouts.app')
@section('title', '我要爆料')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {{--<div class="panel panel-default">--}}
                    <div class="panel-heading" style="">
                        <img src="{{ URL::asset('/') }}img/2X/write.png" width="24px" height="30px" style="padding-bottom: 6px;">&nbsp;&nbsp;
                        <span class="font-header"><b>我要爆料</b></span></div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('article') }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <textarea name="body" class="form-control" maxlength="250" rows="9" placeholder="请输入反映的问题"></textarea>
                            </div>
                            <div class="form-group form-anonymous">
                                <label style="float:left;color:#999;font-size:10px;font-weight: normal; margin-top: 4px;">(最多250字)</label>

                                    <label style="float:right;font-weight: normal;">
                                        <input type="checkbox" name="anonymous[]" style="vertical-align:middle; margin-top: 0; margin-bottom: 1px;">

                                        <span class="font-anonymous">我要匿名</span>
                                    </label>

                            </div>
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="请输入真实姓名（选填）">
                            </div>
                            <div class="form-group">
                                <input type="number" name="mobile" class="form-control" placeholder="请输入手机号码">
                            </div>

                            <div class="form-group">
                                <input type="text" name="address" class="form-control" placeholder="请输入地址">
                            </div>
                            <div class="form-group">
                                    <label class="sr-only" for="inputfile">选择图片</label>
                                    <input type="file" id="iptImage" name="iptImage" style="display:none;">
                                    <input type="hidden" id="iptImageUrls" name="iptImageUrls">
                                <span id="image-holder"></span><img class="cover_small" style="display: inline-block;" src="{{ URL::asset('/') }}img/1X/image-add.png" onclick="iptImage.click();"/>
                            </div>
                            <div class="form-group" style="margin-top: 25px;">
                                <input type="submit" class="btn btn-success btn-block" value="提 交" name="submit">
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>提交失败</strong> 输入不符合要求<br><br>
                                    {!! implode('<br>', $errors->all()) !!}
                                </div>
                            @endif
                        </form>
                    </div>
                {{--</div>--}}
            </div>
        </div>
    </div>
    {{--<script type="text/javascript" src="{{ URL::asset('/js/common.js') }}"></script>--}}
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('body').append("<div style='display:none;width:100%; margin:0 auto;position:fixed;left:0;top:0;bottom: 0;z-index: 111;opacity: 0.5;' id='loading'> <a class='mui-active' style='left: 50%;position: absolute;top:50%'><img src='{{ URL::asset('/') }}img/uploading.gif' style='margin-left: -10px;' /></a></div>");
        })

        $("#iptImage").on('change', function(){
//            console.log(this.files);
            var formData = new FormData();
            formData.append('iptImage', $('#iptImage')[0].files[0]);

            $.ajax({
                url: '/file/upload',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    $("#loading").show();
                }
            }).done(function(res) {
                        $("#loading").hide();
                        var imgUrl = "" + res;
                        console.log(imgUrl);
                        console.log("image length=" + $("#image-holder > img").length );
                        if($("#image-holder > img").length >=3){
                            console.log("最多只能传3张");
                            alert("最多只能上传3张照片");
//                        }else if($("#image-holder > img").length <=0){
//                            alert("必须上传照片");
//                            return false;
                        }else {
                            $("#image-holder").append('<img src="' + imgUrl + '" class="cover_small">');
                            $("#iptImageUrls").val($("#iptImageUrls").val() + "," + imgUrl);
                        }
                    })
                    .fail(function(res) {});
        })
    </script>
@endsection