<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-3 py-md-5 my-3">
    <div class="row">
        <div class="card w-100 mb-3">
            <?php if(empty($rs['list'])): ?>
            <div class="text-center mt-4 mb-2">
                <i class="fas fa-exclamation-circle"></i> 购物车空空如也
            </div>
            <div class="text-center mt-2 mb-4">
                <a href="/" class="btn btn-outline-info">去首页看看</a>
            </div>
            <?php else: ?>
            <div class="card-body">
                <?php $__currentLoopData = $rs['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="media mb-3">
                    <div class="col-md-3 border-right">
                        <a href="<?php echo e($item['cover']); ?>" class="magnific-popup">
                            <img src="<?php echo e($item['cover']); ?>" class="mr-3 rounded" style="max-height: 160px; max-width: 100%;">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <a href="<?php echo e('/good/detail?' . http_build_query(['good_id' => $item['id']])); ?>" class="pure-link text-dark">
                                    <?php echo e($item['title']); ?>

                                </a>
                            </h5>
                            <div>￥<?php echo e($item['price_unit']); ?> x <?php echo e($item['num']); ?> = ￥<?php echo e($item['price_sum']); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div>
                    <span>购物车小计：</span><span>￥<?php echo e($rs['sum']); ?></span>
                </div>
                <button type="button" class="btn btn-outline-primary pay-btn" data-sum="<?php echo e($rs['sum']); ?>">点击支付</button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
<script>
    $('.pay-btn').click(function () {
        const $btn = $(this);
        const amount_sum = $btn.data('sum');

        Swal.fire({
            icon: 'question',
            title: '请选择要模拟支付的状态？',
            showDenyButton: true,
            showCancelButton: true,
            denyButtonText: '模拟【支付失败】',
            cancelButtonText: '模拟【等待支付】',
            confirmButtonText: '模拟【支付成功】',
        }).then((result) => {
            let pay_status = -1;
            if (result.isDismissed) {
                pay_status = 0;
                $btn.prop('disabled', true);
            } else if (result.isConfirmed) {
                pay_status = 1;
                $btn.prop('disabled', true);
            } else if (result.isDenied) {
                pay_status = 2;
                $btn.prop('disabled', true);
            }

            if (pay_status === -1) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/good/submit',
                data: {amount_sum, pay_status},
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

    $('.collect-btn').click(function () {
        const $btn = $(this);
        const btn_info = $btn.text();
        const good_id = $btn.closest('.toolbar').data('id');
        const is_yes = $btn.data('yes');

        YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/collect',
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

    $('.cart-btn').click(function () {
        const $btn = $(this);
        const btn_info = $btn.text();
        const good_id = $btn.closest('.toolbar').data('id');
        const good_num = 1;

        // YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/addCart',
                data: {good_id, good_num},
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
        // });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\laravel_project\resources\views/shop1/index/good_cart.blade.php ENDPATH**/ ?>