<?php $__env->startSection('content'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">购你所需</h1>
        <p class="lead font-weight-normal">HAPPY NEW LIFE</p>
        
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>




<div class="d-flex justify-content-center align-items-center mt-4 mb-4">
    <form class="form-inline">
        <?php $__currentLoopData = $labelRel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="label" id="inlineRadio<?php echo e($k); ?>" value="<?php echo e($k); ?>" <?php echo e($k == $label ? 'checked' : ''); ?>>
            <label class="form-check-label" for="inlineRadio<?php echo e($k); ?>"><?php echo e($v); ?></label>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search fa-sm"></i> 标签筛选</button>
        </div>
    </form>
</div>

<div class="container">
    <div class="row">
        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- <div class="pt-3 px-3 pt-md-3 px-md-5 text-center overflow-hidden col-6 mb-3 border"> -->
         <div class="  text-center  border overflow-hidden mb-3  ">
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
                    <?php echo e($item->amount); ?></div>
            </div>
            <div class="mx-auto" style="width: 80%; height: 300px;">
                <a href="<?php echo e('/good/detail?' . http_build_query(['good_id' => $item->id])); ?>" class="pure-link text-dark">
                    <img src="<?php echo e($item->cover); ?>" class="mw-100 mh-100 shadow-sm" style="border-radius: 8px 8px 0 0; width: 300px;height: 240px">
                </a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="row">
    <div class="mx-auto">
    <?php echo $__env->make('shop1.layout.page', ['paginator' => $list], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop1.layout.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\guo15\Desktop\shop\shop\resources\views/shop1/index/index.blade.php ENDPATH**/ ?>