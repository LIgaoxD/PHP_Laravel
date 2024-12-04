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
        <form id="edit-form">
            <div class="form-group">
                <label for="exampleInputEmail1">密码</label>
                <input type="password" class="form-control" id="exampleInputEmail1" name="pwd">
            </div>
            <div class="form-group">
                <label for="exampleInputNickname">重复密码</label>
                <input type="password" class="form-control" id="exampleInputNickname" name="pwd_re">
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
            url: '/my/pwd',
            success: (res) => {
                if (res.code) {
                    return YY_FRONT.alertError(res.msg);
                }
                YY_FRONT.alertSuccess(res.msg, function () {
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
