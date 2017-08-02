@extends('layouts.app')
@section('title', '我要爆料')
@section('content')
    <div class="container">
        <div class="vertical-center" style="text-align: center;">
                        <img src="{{ URL::asset('/') }}img/1X/success.png" width="74px" height="74px" style="margin: 5px auto;">
                        <div style="font-size:36px;color: #32bd69;margin: 5px auto;">
                            提 交 成 功
                        </div>
                        <div style="font-size:14px;color: #999;margin: 5px auto;">
                            感谢参与活动
                        </div>
        </div>
    </div>
@endsection