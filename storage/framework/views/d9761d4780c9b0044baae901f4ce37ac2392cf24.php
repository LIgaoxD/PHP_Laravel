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
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" class="form-control" id="exampleInputEmail1" readonly value="<?php echo e($info['name']); ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputNickname">昵称</label>
                <input type="text" class="form-control" id="exampleInputNickname" readonly value="<?php echo e($info['nickname']); ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputSex">性别</label>
                <input type="text" class="form-control" id="exampleInputSex" readonly value="<?php echo e($info['sex_str']); ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputIntro">简介</label>
                <textarea class="form-control" rows="3" id="exampleInputIntro" readonly><?php echo e($info['intro']); ?></textarea>
            </div>
            <a href="/my/edit" class="btn btn-outline-info">去修改</a>
            <a href="/my/pwd" class="btn btn-outline-info ml-2">去改密</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\guo15\Desktop\shop\shop\resources\views/shop1/my/index.blade.php ENDPATH**/ ?>