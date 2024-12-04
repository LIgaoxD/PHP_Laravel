<?php $__env->startSection('content'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">我的订单</h1>
        
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
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card w-100 mb-3" data-order="<?php echo e($item->order_no); ?>">
            <div class="card-header d-flex justify-content-between">
                <div>订单编号：<span><?php echo e($item->order_no); ?></span></div>
                <div class="<?php echo e($item->pay_class); ?> line-initial"><?php echo e($item->pay_txt); ?></div>
            </div>
            <div class="card-body">
                <?php $__currentLoopData = $item->orderItem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="media mb-2">
                    <div class="col-md-3 border-right">
                        <a href="<?php echo e($v_item->goodData->cover); ?>" class="magnific-popup">
                            <img src="<?php echo e($v_item->goodData->cover); ?>" class="mr-3 rounded" style="max-height: 160px;  max-width: 100%;">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <a href="<?php echo e('/good/detail?' . http_build_query(['good_id' => $v_item->good_id])); ?>" class="pure-link text-dark">
                                    <?php echo e($v_item->goodData->title); ?>

                                </a>
                            </h5>
                            <div>￥<?php echo e($v_item->amount_unit); ?> x <?php echo e($v_item->num); ?> = ￥<?php echo e($v_item->amount_sum); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span>订单总计：</span><span>￥<?php echo e($item->amount_total); ?></span>
                    </div>
                    <?php if($item->is_pay_wait): ?>
                    <button type="button" class="btn btn-outline-primary wait-btn">点击支付</button>
                    <?php endif; ?>
                </div>
                <?php if($item->is_pay_yes): ?>
                <div>
                    支付时间：<?php echo e($item->pay_time); ?>

                </div>
                <?php endif; ?>
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
    $('.wait-btn').click(function () {
        const $btn = $(this);
        const order_no = $btn.closest('.card').data('order');

        Swal.fire({
            icon: 'question',
            title: '请选择要模拟支付的状态？',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: '模拟【支付成功】',
            denyButtonText: '模拟【支付失败】',
        }).then((result) => {
            let mock_status = -1;
            if (result.isConfirmed) {
                mock_status = 1;
                $btn.prop('disabled', true);
            } else if (result.isDenied) {
                mock_status = 2;
                $btn.prop('disabled', true);
            }

            if (mock_status === -1) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/my/orderPay',
                data: {order_no, mock_status},
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

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\guo15\Desktop\shop\shop\resources\views/shop1/my/order.blade.php ENDPATH**/ ?>