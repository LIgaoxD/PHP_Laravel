<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">网站配置</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-info" role="alert">
                不同的站点主题，前端只展示相应分类的商品
            </div>
            <form class="" id="save-form">
                <div class="form-group">
                    <label>站点名称</label>
                    <input type="text" name="site_name" class="form-control"
                        placeholder="请输入站点名称" value="<?php echo e($all_config['site_name']); ?>">
                </div>
                <div class="form-group" hidden >
                    <label>站点主题</label>
                    <select name="theme" class="form-control">
                        <?php $__currentLoopData = $themeRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>" <?php echo e($all_config['theme'] == $k ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block" id="save-btn">
                    保存
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('foot_js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('foot_js'); ?>
<script>
    $('#save-form').submit(() => {
        $('#save-form').ajaxSubmit({
            type: 'POST',
            url: '/admin/theme',
            success: (res) => {
                if (res.code) {
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
        return false;
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\phpstudy_pro\WWW\shop\resources\views/admin1/index/theme.blade.php ENDPATH**/ ?>