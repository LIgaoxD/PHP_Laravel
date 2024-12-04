<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo e($site_name); ?></title>

    <?php $__env->startSection('head_css'); ?>
    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap core CSS -->
    

    <link href="/admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/admin/js/toastr.min.css" rel="stylesheet">
    <link href="/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/product.css" rel="stylesheet">
    <link href="/shop1/css/base_front.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <?php echo $__env->yieldSection(); ?>
</head>
<body>
    <nav class="site-header sticky-top py-1">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <a class="py-2" href="/" aria-label="Product" title="<?php echo e($site_name); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-inline-block mx-auto" role="img" viewBox="0 0 24 24" focusable="false"><title><?php echo e($site_name); ?></title><circle cx="12" cy="12" r="10"/><path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>
                <span class="ml-1"><?php echo e($site_name); ?></span>
            </a>
            <div>
                <?php if($user_id): ?>
                <a class="px-3 d-md-inline-block align-middle" href="/good/cart">
                    <i class="fas fa-cart-arrow-down"></i> 购物车
                    <?php if($cart_num > 0): ?>
                    <span class="badge badge-light"><?php echo e($cart_num); ?></span>
                    <?php endif; ?>
                </a>
                <div class="dropdown d-inline-block">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                        <?php echo e($user->name); ?>

                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <a class="dropdown-item" href="/my/index">个人中心</a>
                        <a class="dropdown-item" href="/my/order">我的订单</a>
                        
                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">注销</a>
                    </div>
                </div>
                <?php else: ?>
                <a class="py-2 d-none d-md-inline-block" href="/login">登录</a>
                <a class="py-2 d-none d-md-inline-block ml-4" href="/register">注册</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <div class="w-100">
        <hr class="mt-4">
    </div>
    <footer class="container py-4">
        <div class="row">
            <small class="mb-3 mx-auto text-muted"><?php echo e($site_name); ?> &copy; 2022</small>
        </div>
    </footer>

    <?php $__env->startSection('foot_js'); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sweetalert2.all.min.js"></script>
    <script src="/admin/js/toastr.min.js"></script>
    <script src="/admin/js/jquery.form.min.js"></script>
    <script src="/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="/shop1/js/base_front.js"></script>
    <script>
        <?php if(session('toastr_info')): ?>
        YY_FRONT.toastrInfo("<?php echo e(session('toastr_info')); ?>");
        <?php endif; ?>
    </script>
    <?php echo $__env->yieldSection(); ?>
</body>
</html>
<?php /**PATH D:\phpstudy_pro\WWW\laravel\shop\resources\views/shop1/layout/base.blade.php ENDPATH**/ ?>