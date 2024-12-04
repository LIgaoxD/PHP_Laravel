<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">用户列表</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->

    <form class="form-inline mb-3">
        <div class="form-group">
            <label>用户名</label>
            <input type="text" name="name" class="form-control mx-sm-3" placeholder="请输入用户名" value="<?php echo e($name); ?>">
        </div>
        <div class="form-group">
            <label>昵称</label>
            <input type="text" name="nickname" class="form-control mx-sm-3" placeholder="请输入昵称" value="<?php echo e($nickname); ?>">
        </div>
        <div class="form-group">
            <label>性别</label>
            <select name="sex" class="form-control mx-sm-3">
                <option value="">请选择</option>
                <?php $__currentLoopData = $sexRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php echo e(is_numeric($sex) && $k == $sex ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label>状态</label>
            <select name="status" class="form-control mx-sm-3">
                <option value="">请选择</option>
                <?php $__currentLoopData = $statusRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php echo e(is_numeric($status) && $k == $status ? 'selected' : ''); ?>><?php echo e($v); ?></option>
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
                <th scope="col" width="10%">用户名</th>
                <th scope="col" width="10%">昵称</th>
                <th scope="col" width="8%">性别</th>
                <th scope="col" width="30%">简介</th>
                <th scope="col" width="8%">状态</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-id="<?php echo e($item->id); ?>">
                <td><?php echo e($item->id); ?></td>
                <td><?php echo e($item->name); ?></td>
                <td><?php echo e($item->nickname); ?></td>
                <td><?php echo e($item->sex_str); ?></td>
                <td class="break-line"><?php echo e($item->intro); ?></td>
                <td>
                    <span class="<?php echo e($item->status_class); ?>"><?php echo e($item->status_str); ?></span>
                </td>
                <td>
                    <?php if($item->status == 1): ?>
                    <button type="button" class="btn btn-dark status-btn" data-status="0">禁用</button>
                    <?php else: ?>
                    <button type="button" class="btn btn-info status-btn" data-status="1">启用</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-warning pwd-btn ml-1">改密</button>
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
    $('.status-btn').click(function () {
        const $btn = $(this);
        const status = $btn.data('status');
        const user_id = $btn.closest('tr').data('id');

        YY.swalConfirm('确定' + $btn.text() + '此用户吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/admin/userDeny',
                data: {status, user_id},
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

    $('.pwd-btn').click(async function () {
        const $btn = $(this);
        const user_id = $btn.closest('tr').data('id');
        console.log('pwd', user_id);
        const { value: pwd } = await Swal.fire({
            showCancelButton: true,
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            title: '修改用户密码',
            input: 'password',
            inputLabel: '请输入用户新密码',
            // inputPlaceholder: '请输入用户新密码',
        });
        if (!pwd) {
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/admin/userPwd',
            data: {pwd, user_id},
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\guo15\Desktop\shop\shop\resources\views/admin1/user/index.blade.php ENDPATH**/ ?>