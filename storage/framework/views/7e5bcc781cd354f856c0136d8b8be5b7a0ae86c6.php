<?php $__env->startSection('content'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">个人中心</h1>
        
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>
<div class="container">
    <div class="mb-3">
        <a class="btn <?php echo e(in_array($request_path, ['my/index', 'my/edit']) ? 'btn-primary' : 'btn-outline-primary'); ?>"
            href="/my/index" role="button">基本信息</a>
        <a class="btn <?php echo e($request_path === 'my/order' ? 'btn-primary' : 'btn-outline-primary'); ?> ml-2"
            href="/my/order" role="button">我的订单</a>
        
            
        
            
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\shop\resources\views/shop1/my/pwd.blade.php ENDPATH**/ ?>