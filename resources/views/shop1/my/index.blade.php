@extends('shop1.layout.base')

@section('content')
<div class="position-relative overflow-hidden text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: black;">
        <!-- 大标题 -->
        <h1 class="display-5 font-weight-normal" style="margin-bottom: 24px;">个人中心</h1>
        <!-- 副标题 -->
        <h6 class=" font-weight-normal">HAPPY NEW LIFE</h6>
    </div>
</div>
<div class="container">
    <div class="mb-3">
        <a class="btn {{ in_array($request_path, ['my/index', 'my/edit']) ? 'btn-primary' : 'btn-outline-primary' }}"
            href="/my/index" role="button">基本信息</a>
        <a class="btn {{ $request_path === 'my/order' ? 'btn-primary' : 'btn-outline-primary' }} ml-2"
            href="/my/order" role="button">我的订单</a>
        <a class="btn {{ $request_path === 'my/collect' ? 'btn-primary' : 'btn-outline-primary' }} ml-2"
            href="/my/collect" role="button">我的收藏</a>
        <a class="btn {{ $request_path === 'my/like' ? 'btn-primary' : 'btn-outline-primary' }} ml-2"
            href="/my/like" role="button">我的点赞</a>
    </div>
    <div>
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" class="form-control" id="exampleInputEmail1" readonly value="{{ $info['name'] }}">
            </div>
            <div class="form-group">
                <label for="exampleInputNickname">昵称</label>
                <input type="text" class="form-control" id="exampleInputNickname" readonly value="{{ $info['nickname'] }}">
            </div>
            <div class="form-group">
                <label for="exampleInputSex">性别</label>
                <input type="text" class="form-control" id="exampleInputSex" readonly value="{{ $info['sex_str'] }}">
            </div>
            <div class="form-group">
                <label for="exampleInputIntro">简介</label>
                <textarea class="form-control" rows="3" id="exampleInputIntro" readonly>{{ $info['intro'] }}</textarea>
            </div>
            <a href="/my/edit" class="btn btn-outline-info">去修改</a>
            <a href="/my/pwd" class="btn btn-outline-info ml-2">去改密</a>
        </form>
    </div>
</div>
@endsection
