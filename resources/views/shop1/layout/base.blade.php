<!doctype html>
<html lang="en">

<head>
    <!-- 设置文档字符编码为UTF-8 -->
    <meta charset="utf-8">
    <!-- 指定使用最新版本的IE引擎 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 设置移动设备的视口，确保在各种设备上显示合适 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- 指定渲染引擎为Webkit（比如 Chrome 或 Safari）-->
    <meta name="renderer" content="webkit">
    <!-- CSRF令牌，用于保护表单提交等 -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- 网页的描述信息 -->
    <meta name="description" content="">
    <!-- 网页的作者信息 -->
    <meta name="author" content="">
    <!-- 设置网页标题，使用了一个变量 $site_name -->
    <title>{{ $site_name }}</title>

    @section('head_css')
    <!-- 引入自定义字体 -->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- 引入Bootstrap核心CSS -->
    {{-- <link href="/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- 引入自定义的样式表 -->
    <link href="/admin/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- 引入消息提示框的样式表 -->
    <link href="/admin/js/toastr.min.css" rel="stylesheet">
    <!-- 引入图片弹窗的样式表 -->
    <link href="/magnific-popup/magnific-popup.css" rel="stylesheet">
    <!-- 引入自定义样式 -->
    <link href="/css/product.css" rel="stylesheet">
    <!-- 引入另一个自定义样式 -->
    <link href="/shop1/css/base_front.css" rel="stylesheet">

    <!-- 自定义的CSS样式 -->
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
    @show
</head>

<body>
    <!-- 网站的顶部导航栏 -->
    <nav class="site-header sticky-top py-1">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center" style="color: black;">
            <!-- 网站Logo和名称 -->
            <a class="py-2" href="/" aria-label="Product" title="{{ $site_name }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-inline-block mx-auto" role="img" viewBox="0 0 24 24" focusable="false">
                    <title>{{ $site_name }}</title>
                    <circle cx="12" cy="12" r="10" />
                    <path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94" />
                </svg>
                <span class="ml-1" style="color: black;">{{ $site_name }}</span>
            </a>
            <div>
            
                <!-- 如果用户已登录 -->
                @if ($user_id)
                <!-- 购物车图标和链接 -->
                <a class="px-3 d-md-inline-block align-middle" href="/good/cart" style="margin-right: 12px;color:black">   
                    <i class="fas fa-cart-arrow-down" style="color: black;margin-right:12px;"></i>购物车          
                    <!-- 如果购物车中有商品，则显示徽章 -->
                    @if ($cart_num > 0)      
                    <span class="badge badge-light">{{ $cart_num }}</span>
                    @endif
                </a>
                <i class="fa fa-search" aria-hidden="true" / style="margin-left: 44px;"></i>
                <!-- 用户下拉菜单 -->
                <div class="dropdown d-inline-block">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false" style="margin-left: 12px;">
                        {{ $user->name }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <a class="dropdown-item" href="/my/index">个人中心</a>
                        <a class="dropdown-item" href="/my/order">我的订单</a>
                        <a class="dropdown-item" href="/my/collect">我的收藏</a>
                        <a class="dropdown-item" href="/my/like">我的点赞</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">注销</a>
                    </div>
                </div>
                <!-- 如果用户未登录 -->
                @else
                <!-- 登录链接 -->
                <a class="py-2 d-none d-md-inline-block" href="/login" style="color: black;">登录</a>
                <!-- 注册链接 -->
                <a class="py-2 d-none d-md-inline-block ml-4" href="/register" style="color: black;">注册</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- 占位符，用于插入具体内容 -->
    @yield('content')

    <!-- 分隔线 -->
    <div class="w-100">
        <hr class="mt-4">
    </div>
    <!-- 页脚 -->
    <footer class="container py-4">
        <div class="row">
            <!-- 版权信息 -->
            <small class="mb-3 mx-auto text-muted" >{{ $site_name }}<i class="fa fa-globe" aria-hidden="true"style="margin: 12px;"></i>
                Copyright &copy; 2023. The team of us&nbsp;法律声明&nbsp;|&nbsp;隐私条款
            </small>
        </div>
    </footer>

    @section('foot_js')
    <!-- 引入jQuery -->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <!-- 引入Bootstrap核心JavaScript -->
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- 引入jQuery easing插件 -->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- 引入SweetAlert2库 -->
    <script src="/admin/js/sweetalert2.all.min.js"></script>
    <!-- 引入消息提示框库 -->
    <script src="/admin/js/toastr.min.js"></script>
    <!-- 引入jQuery form插件 -->
    <script src="/admin/js/jquery.form.min.js"></script>
    <!-- 引入图片弹窗库 -->
    <script src="/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- 引入自定义JavaScript -->
    <script src="/shop1/js/base_front.js"></script>
    <script>
        // 如果有消息提示，则显示
        if (session('toastr_info')) {
            YY_FRONT.toastrInfo("{{ session('toastr_info') }}");
        }
    </script>
    @show
</body>

</html>