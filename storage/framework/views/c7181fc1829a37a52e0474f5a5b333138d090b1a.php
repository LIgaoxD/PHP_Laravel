<?php $__env->startSection('content'); ?>
<div class="position-relative overflow-hidden text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: black;">
        <!-- 大标题 -->
        <h1 class="display-5 font-weight-normal" style="margin-bottom: 24px;">我的点赞</h1>
        <!-- 副标题 -->
        <h6 class=" font-weight-normal">HAPPY NEW LIFE</h6>
    </div>
</div>
<div class="container">
    <div class="mb-3">
        <a class="btn <?php echo e(in_array($request_path, ['my/index', 'my/edit']) ? 'btn-primary' : 'btn-outline-primary'); ?>"
            href="/my/index" role="button">基本信息</a>
        <a class="btn <?php echo e($request_path === 'my/order' ? 'btn-primary' : 'btn-outline-primary'); ?> ml-2"
            href="/my/order" role="button">我的订单</a>
        <a class="btn <?php echo e($request_path === 'my/collect' ? 'btn-primary' : 'btn-outline-primary'); ?> ml-2"
            href="/my/collect" role="button">我的收藏</a>
        <a class="btn <?php echo e($request_path === 'my/like' ? 'btn-primary' : 'btn-outline-primary'); ?> ml-2"
            href="/my/like" role="button">我的点赞</a>
    </div>
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 mb-3 card-div" data-id="<?php echo e($item->good_id); ?>">
            <div class="card" style="width: 18rem;">
                <img src="<?php echo e($item->good_cover); ?>" class="card-img-top" style="height: 300px;">
                <div class="card-body">
                    <h5 class="card-title line-1"
                        data-toggle="tooltip" data-placement="top" title="<?php echo e($item->good_title); ?>"><?php echo e($item->good_title); ?></h5>
                    <p class="card-text">￥<?php echo e($item->good_amount); ?></p>
                     <p class="card-text line-2" style="height: 48px;"><?php echo e($item->good_title_sub); ?></p> 
                    <a href="<?php echo e('/good/detail?' . http_build_query(['id' => $item->good_id])); ?>" class="btn btn-outline-primary">查看</a>
                    <button type="button" class="btn btn-outline-primary cancel-btn">取消点赞</a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="mx-auto">
            <div>
                <img src="/shop1/img/empty-box.png">
            </div>
            <div class="mt-1 text-center text-info">
                空空如也
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="mx-auto">
        <?php echo $__env->make('shop1.layout.page', ['paginator' => $list], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
<script>
    $('.cancel-btn').click(function () {
        const $btn = $(this);
        const good_id = $btn.closest('.card-div').data('id');
        const is_yes = 0;

        YY_FRONT.swalConfirm('确定要取消点赞吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/like',
                data: {good_id, is_yes},
                success: (res) => {
                    if (res.code) {
                        $btn.prop('disabled', false);
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
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\laravel_project\resources\views/shop1/my/like.blade.php ENDPATH**/ ?>