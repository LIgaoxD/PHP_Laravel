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
        <a class="btn {{ in_array($request_path, ['my/index', 'my/edit']) ? 'btn-primary' : 'btn-outline-primary' }}" href="/my/index" role="button">基本信息</a>
        <a class="btn {{ $request_path === 'my/order' ? 'btn-primary' : 'btn-outline-primary' }} ml-2" href="/my/order" role="button">我的订单</a>
        <a class="btn {{ $request_path === 'my/collect' ? 'btn-primary' : 'btn-outline-primary' }} ml-2" href="/my/collect" role="button">我的收藏</a>
        <a class="btn {{ $request_path === 'my/like' ? 'btn-primary' : 'btn-outline-primary' }} ml-2" href="/my/like" role="button">我的点赞</a>
    </div>
    <div>
        <form id="edit-form">
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" class="form-control" id="exampleInputEmail1" readonly value="{{ $user['name'] }}" data-toggle="tooltip" data-placement="top" title="用户名禁止修改">
            </div>
            <div class="form-group">
                <label for="exampleInputNickname">昵称</label>
                <input type="text" class="form-control" id="exampleInputNickname" name="nickname" value="{{ $user['nickname'] }}">
            </div>
            <div class="form-group">
                <label for="exampleInputSex">性别</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="1" {{ 1 == $user['sex'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio1">男</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="2" {{ 2 == $user['sex'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio2">女</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputIntro">简介</label>
                <textarea class="form-control" rows="3" id="exampleInputIntro" name="intro">{{ $user['intro'] }}</textarea>
            </div>
            <button type="submit" class="btn btn-info">保存</button>
        </form>
    </div>
</div>
@endsection

@section('foot_js')
@parent
<script>
    $('#edit-form').submit(() => {
        $('#edit-form').ajaxSubmit({
            type: 'POST',
            url: '/my/edit',
            success: (res) => {
                if (res.code) {
                    return YY_FRONT.alertError(res.msg);
                }
                YY_FRONT.alertSuccess(res.msg, function() {
                    if (res.redirect) {
                        location.href = res.redirect;
                    }
                    if (res.reload) {
                        location.reload();
                    }
                });
            },
        });
        return false;
    });
</script>
@endsection