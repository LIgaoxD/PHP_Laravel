<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-3 py-md-5 my-3">
    <div class="row">
        <div class="col-md-4">
            <a href="<?php echo e($rs['cover']); ?>" class="magnific-popup">
                <img src="<?php echo e($rs['cover']); ?>" style="max-height: 400px; max-width: 100%;">
            </a>
        </div>
        <div class="col-md-8" style="position: relative;">
            <h2 class="mb-2"><?php echo e($rs['title']); ?></h2>
            <div class="mb-2 text-muted"><?php echo e($rs['title_sub']); ?></div>
            <div class="lead mb-2">
                <?php $__currentLoopData = $rs['label_arr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="badge badge-secondary badge-font"><?php echo e($label_item); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="lead">
                <span class="price-sign">￥</span>
                <?php echo e($rs['amount']); ?>

            </div>
            <div style="position: absolute; bottom: 0;" class="toolbar" data-id="<?php echo e($rs['id']); ?>">
                <?php if($rs['is_like']): ?>
                
                <?php else: ?>
                
                <?php endif; ?>
                <?php if($rs['is_collect']): ?>
                
                <?php else: ?>
                
                <?php endif; ?>
                <button type="button" class="btn btn-warning ml-2 cart-btn"><i class="fas fa-plus"></i> 加入购物车</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
<script>
    $('.like-btn').click(function () {
        const $btn = $(this);
        const btn_info = $btn.text().trim();
        const good_id = $btn.closest('.toolbar').data('id');
        const is_yes = $btn.data('yes');

        YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
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

    $('.collect-btn').click(function () {
        const $btn = $(this);
        const btn_info = $btn.text().trim();
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

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\laravel\shop\resources\views/shop1/index/good_detail.blade.php ENDPATH**/ ?>