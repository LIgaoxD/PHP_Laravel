<?php $__env->startSection('head_css'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('head_css'); ?>
<link href="/jQuery-File-Upload-10.32.0/css/jquery.fileupload.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e($h_title); ?></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row pb-4">
        <div class="col-md-6">
            <form class="" id="save-form">
                <?php if(!empty($data_good['id'])): ?>
                    <input type="hidden" name="good_id" value="<?php echo e($data_good['id']); ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label>商品标题</label>
                    <input type="text" name="title" class="form-control"
                        placeholder="请输入商品标题" value="<?php echo e($data_good['title'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>商品副标题</label>
                    <textarea name="title_sub" class="form-control" rows="2" placeholder="请输入商品副标题"><?php echo e($data_good['title_sub'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="cover" value="<?php echo e($data_good['cover'] ?? ''); ?>">
                    <label>商品图片</label>
                    <div>
                        <button type="button" class="btn btn-info fileinput-button">
                            <input class="upload-btn" type="file" name="file" accept=".jpg,.jpeg,.png,.gif">
                            <span>上传图片</span>
                        </button>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo e($data_good['cover'] ?? ''); ?>" class="magnific-popup <?php echo e($data_good['cover'] ?? 'd-none'); ?>">
                            <img src="<?php echo e($data_good['cover'] ?? ''); ?>" class="good-img" id="good-img-id">
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <label>商品价格</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">￥</div>
                        </div>
                        <input type="text" name="amount" class="form-control"
                            placeholder="请输入商品价格" value="<?php echo e($data_good['amount'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group" hidden>
                    <label>商品分类</label>
                    <select name="cate" class="form-control">
                        <?php $__currentLoopData = $cateRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>" <?php echo e(isset($data_good['cate']) && $data_good['cate'] == $k ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>商品标签</label>
                    <select name="label[]" class="form-control" multiple>
                        <?php $__currentLoopData = $labelRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>" <?php echo e(isset($data_good['label_data']) && in_array($k, $data_good['label_data']) ? 'selected' : ''); ?>><?php echo e($v); ?></option>
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
<script src="/jQuery-File-Upload-10.32.0/js/vendor/jquery.ui.widget.js"></script>
<script src="/jQuery-File-Upload-10.32.0/js/jquery.iframe-transport.js"></script>
<script src="/jQuery-File-Upload-10.32.0/js/jquery.fileupload.js"></script>
<script>
    $('#save-form').submit(() => {
        $('#save-form').ajaxSubmit({
            type: 'POST',
            url: '/admin/goodEdit',
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

    $('.upload-btn').fileupload({
        url: '/admin/goodPic',
        success: function (result) {
            // var $input = $(this.fileInputClone);
            if (result.code) {
                return YY.alertError(result.msg);
            }

            $('[name=cover]').val(result.data.pic);
            $('#good-img-id').prop('src', result.data.pic)
                .closest('a')
                .prop('href', result.data.pic)
                .removeClass('d-none');
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\guo15\Desktop\shop\shop\resources\views/admin1/good/edit.blade.php ENDPATH**/ ?>