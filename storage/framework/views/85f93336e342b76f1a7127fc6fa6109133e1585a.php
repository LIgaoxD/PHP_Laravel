<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">商品列表</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        <div class="">
            <a href="<?php echo e(url('/admin/goodEdit')); ?>" class="btn btn-info">新增</a>
        </div>
    </div>

    <!-- Content Row -->

    <form class="form-inline mb-3">
        <div class="form-group">
            <label>商品标题</label>
            <input type="text" name="title" class="form-control mx-sm-3" placeholder="请输入商品标题" value="<?php echo e($title); ?>">
        </div>

        <div class="form-group">
            <label>标签</label>
            <select name="label" class="form-control mx-sm-3">
                <option value="">请选择</option>
                <?php $__currentLoopData = $labelRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php echo e(!empty($label) && $k == $label ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm"></i></button>
        </div>
    </form>

    <table class="table table-bordered form-table mb-3">
        <thead>
            <tr>
                <th scope="col" width="60">ID</th>
                <th scope="col" width="140">商品图片</th>
                <th scope="col" width="35%">商品标题</th>
                <th scope="col" width="10%">价格</th>
                <th scope="col" width="15%">标签</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-id="<?php echo e($item->id); ?>">
                <td><?php echo e($item->id); ?></td>
                <td>
                    <a href="<?php echo e($item->cover); ?>" class="magnific-popup">
                        <img src="<?php echo e($item->cover); ?>" class="rounded good-img">
                    </a>
                </td>
                <td class="break-line">
                    <div class="text-dark"><?php echo e($item->title); ?></div>
                    <div class="text-secondary small"><?php echo e($item->title_sub); ?></div>
                </td>
                <td>
                    ￥ <?php echo e($item->amount); ?>

                </td>

                <td>
                    <?php $__currentLoopData = $item->label_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge badge-secondary badge-font"><?php echo e($label_item); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                    <a href="<?php echo e(url('/admin/goodEdit?') . http_build_query(['good_id' => $item->id])); ?>" class="btn btn-info">编辑</a>
                    <button type="button" class="btn btn-danger del-btn">删除</button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="float-right">
    <?php echo $__env->make('admin1.layout.page', ['paginator' => $list->appends($search_data)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
<script>
    $('.del-btn').click(function () {
        const $btn = $(this);
        const order_no = $btn.closest('tr').data('id');

        YY.swalConfirm('确定删除此商品吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/admin/goodDel',
                data: {order_no},
                success: (res) => {
                    if (res.code) {
                        $btn.prop('disabled', false);
                        return YY.alertError(res.msg);
                    }
                    YY.alertSuccess(res.msg, function () {
                        if (res.redirect) {
                            location.href = res.redirect;
                        }
                        if (res.reload) {
                            location.reload();
                        }
                        if (res.back) {
                            location.href = '<?php echo url()->previous(); ?>';
                        }
                    });
                },
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\laravel_project\resources\views/admin1/good/index.blade.php ENDPATH**/ ?>