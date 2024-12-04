<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">订单列表</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->

    <form class="form-inline mb-3">
        <div class="form-group">
            <label>订单编号</label>
            <input type="text" name="order_no" class="form-control mx-sm-3" placeholder="请输入订单编号" value="<?php echo e($order_no); ?>">
        </div>
        <div class="form-group">
            <label>用户名</label>
            <input type="text" name="name" class="form-control mx-sm-3" placeholder="请输入用户名" value="<?php echo e($name); ?>">
        </div>
        <div class="form-group">
            <label>用户昵称</label>
            <input type="text" name="nickname" class="form-control mx-sm-3" placeholder="请输入用户昵称" value="<?php echo e($nickname); ?>">
        </div>
        <div class="form-group">
            <label>支付状态</label>
            <select name="pay_status" class="form-control mx-sm-3">
                <option value="">请选择</option>
                <?php $__currentLoopData = $payRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php echo e(is_numeric($pay_status) && $k == $pay_status ? 'selected' : ''); ?>><?php echo e($v); ?></option>
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
                <th scope="col" width="140">订单编号</th>
                <th scope="col" width="10%">用户名</th>
                <th scope="col" width="35%">订单内容</th>
                <th scope="col" width="10%">总价</th>
                <th scope="col" width="10%">支付状态</th>
                <th scope="col" width="10%">创建时间</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-id="<?php echo e($item->id); ?>" data-order="<?php echo e($item->order_no); ?>">
                <td><?php echo e($item->id); ?></td>
                <td><?php echo e($item->order_no); ?></td>
                <td>
                    <div><?php echo e($item->user_name); ?></div>
                    <div class="small badge badge-secondary"><?php echo e($item->user_nickname); ?></div>
                </td>
                <td>
                    <?php $__currentLoopData = $item->orderItem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        
                        <span class="small d-inline-block ellipsis"  style="width: 60%"
                            data-toggle="tooltip" data-placement="top" title="<?php echo e($v_item->goodData->title); ?>"><?php echo e($v_item->goodData->title); ?></span>
                        <span class="small d-inline-block ellipsis ml-1">单价：￥<?php echo e($v_item->amount_unit); ?></span>
                        <span class="small d-inline-block ellipsis ml-1">数量：<?php echo e($v_item->num); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>￥<?php echo e($item->amount_total); ?></td>
                <td>
                    <span class="<?php echo e($item->pay_class); ?>"><?php echo e($item->pay_str); ?></span>
                    <?php if($item->is_pay_yes): ?>
                    <div class="small mt-1 text-muted"><?php echo e($item->pay_time); ?></div>
                    <?php endif; ?>
                </td>
                <td><?php echo e($item->create_at); ?></td>
                <td>
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
        const order_no = $btn.closest('tr').data('order');

        YY.swalConfirm('确定删除此订单吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/admin/orderDel',
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

<?php echo $__env->make('admin1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\laravel_project\resources\views/admin1/order/index.blade.php ENDPATH**/ ?>