<?php $__env->startSection('content'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 w-50 m-auto bg-light" style="color: black;">
    <form id="register-form">
        <div class="form-group">
            <label for="exampleInputEmail1">用户名</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="请输入用户名">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">密码</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="请输入密码">
        </div>
        <div class="form-group">
            <label for="exampleInputNickname1">昵称</label>
            <input type="text" name="nickname" class="form-control" id="exampleInputNickname1" placeholder="请输入昵称">
        </div>
        <div class="form-group">
            <label for="exampleInputSex1">性别</label>
            <div>
                <div class="form-check form-check-inline" style="margin-right: 36px;">
                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">男</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">女</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <span style="margin-right: 24px;">已有账号？</span>
            <a href="/login">立即登录</a>
        </div>
        <button type="submit" class="btn btn-primary">立即注册</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
<script>
    $('#register-form').submit(() => {
        $('#register-form').ajaxSubmit({
            type: 'POST',
            url: '/register',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\laravel_project\resources\views/shop1/index/register.blade.php ENDPATH**/ ?>