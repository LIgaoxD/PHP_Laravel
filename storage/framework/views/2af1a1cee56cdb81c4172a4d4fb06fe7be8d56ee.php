<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>后台管理 - <?php echo e($site_name); ?></title>

    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="/admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/admin/js/toastr.min.css" rel="stylesheet">
    <style>
        .right-div {
            padding-top: 10rem !important;
            padding-bottom: 10rem !important;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <?php if(session('alert_msg')): ?>
        <div class="alert alert-success">
            <?php echo e(session('alert_msg')); ?>

        </div>
        <?php endif; ?>

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5 right-div">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">后台管理 - <?php echo e($site_name); ?></h1>
                                    </div>
                                    <form class="user" id="login-form">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control form-control-user"
                                                placeholder="请输入登录用户名">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                placeholder="请输入密码">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" id="login-btn">
                                            登录
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sweetalert2.all.min.js"></script>
    <script src="/admin/js/toastr.min.js"></script>
    <script src="/admin/js/jquery.form.min.js"></script>
    <script src="/admin/js/sb-admin-2.min.js"></script>
    <script src="/admin/js/base_admin.js"></script>

    <script>
        <?php if(session('toastr_info')): ?>
        YY.toastrInfo("<?php echo e(session('toastr_info')); ?>");
        <?php endif; ?>

        $('#login-form').submit(() => {
            $('#login-form').ajaxSubmit({
                type: 'POST',
                url: '/admin/login',
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
</body>

</html>
<?php /**PATH C:\Users\guo15\Desktop\shop\shop\resources\views/admin1/index/login.blade.php ENDPATH**/ ?>