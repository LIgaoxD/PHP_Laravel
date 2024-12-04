<!-- 继承自名为 'shop1.layout.base' 的模板 -->


<!-- 开始定义一个名为 'content' 的占位区域 -->
<?php $__env->startSection('content'); ?>

<!-- 顶部区域，包含了一个背景图片和一些文本 -->
<div class="position-relative overflow-hidden text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: black;">
        <!-- 大标题 -->
        <h1 class="display-5 font-weight-normal" style="margin-bottom: 16px;">购你所需</h1>
        <!-- 副标题 -->
        <h6 class=" font-weight-normal">秋季限定 🌼 全场购物满 ￥666 享9折</h6>
    </div>
</div>



<!-- 标签选择表单 -->
<div class="d-flex justify-content-center align-items-center mt-4 mb-4">
    <form class="form-inline">
        <?php $__currentLoopData = $labelRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-check form-check-inline">
            <!-- 标签单选按钮 -->
            <input class="form-check-input" type="radio" name="label" id="inlineRadio<?php echo e($k); ?>" value="<?php echo e($k); ?>" <?php echo e($k == $label ? 'checked' : ''); ?>>
            <label class="form-check-label" for="inlineRadio<?php echo e($k); ?>" style="margin-right: 24px;color:black;"><?php echo e($v); ?></label>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group">
            <!-- 提交按钮 -->
            <button type="submit" class="btn btn-outline-primary" style="margin: 12px 36px 12px 36px; color:black;"><i class="fas fa-search fa-sm"></i> 标签筛选</button>
        </div>
    </form>
</div>

<!-- 商品列表区域 -->
<div class="container">
    <div class="row">
        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4">
            <div class="text-center border overflow-hidden mb-3" style="color: black;">
                <div class="py-3">
                    <h3 class="display-5 line-1 mb-0">
                        <a href="<?php echo e('/good/detail?' . http_build_query(['good_id' => $item->id])); ?>" class="pure-link text-dark"><?php echo e($item->title); ?></a>
                    </h3>
                    <div class="lead mb-1">
                        <?php $__currentLoopData = $item->label_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge badge-secondary badge-font"><?php echo e($label_item); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="lead">
                        <span class="price-sign">￥</span>
                        <?php echo e($item->amount); ?>

                    </div>
                </div>
                <div class="mx-auto" style="width: 80%; height: 300px;">
                    <a href="<?php echo e('/good/detail?' . http_build_query(['good_id' => $item->id])); ?>" class="pure-link text-dark">
                        <img src="<?php echo e($item->cover); ?>" class="mw-100 mh-100 shadow-sm" style="border-radius: 8px 8px 8px 8px; width: 200px;height: 240px">
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<!-- 分页器 -->
<div class="row">
    <div class="mx-auto">
        <?php echo $__env->make('shop1.layout.page', ['paginator' => $list], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<!-- 结束定义名为 'content' 的占位区域 -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\www\laravel_project\resources\views/shop1/index/index.blade.php ENDPATH**/ ?>