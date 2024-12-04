@extends('shop1.layout.base')

@section('content')
<div class="position-relative overflow-hidden p-3 p-md-5 w-50 m-auto bg-light" style="color: black;">
    <form id="login-form">
        <div class="form-group">
            <label for="exampleInputEmail1">登录用户名</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="请输入登录用户名">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">登录密码</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="请输入登录密码">
        </div>
        <div class="form-group">
            <span style="margin-right: 24px;">还没有账号?</span>
            <a href="/register">立即注册</a>
        </div>
        <button type="submit" class="btn btn-primary">立即登录</button>
    </form>
</div>
@endsection

@section('foot_js')
@parent
<script>
    $('#login-form').submit(() => {
        $('#login-form').ajaxSubmit({
            type: 'POST',
            url: '/login',
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
