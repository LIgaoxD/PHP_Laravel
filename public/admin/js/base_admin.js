const YY = {
     // ajax 错误提示
     alertError(msg, callback, options) {
        const defaults = {
            icon: 'error',
            title: msg,
            showCancelButton: false,
            confirmButtonText: '确定',
            allowOutsideClick: false,
            allowEscapeKey: false,
        };
        $.extend(true, defaults, options || {});
        Swal.fire(defaults).then(function (result) {
            if (result.isConfirmed) {
                $.isFunction(callback) && callback();
            }
        });
    },
    // ajax 成功提示
    alertSuccess(msg, callback, options) {
        const defaults = {
            icon: 'success',
            title: msg,
            timer: 4000,
            showCancelButton: false,
            confirmButtonText: '确定',
            allowOutsideClick: false,
            allowEscapeKey: false,
        };
        $.extend(true, defaults, options || {});
        Swal.fire(defaults).then(function (result) {
            $.isFunction(callback) && callback();
        });
    },
    swalConfirm(msg, confirmCall) {
        Swal.fire({
            icon: 'warning',
            title: msg,
            showCancelButton: true,
            confirmButtonText: '确定',
            cancelButtonText: '取消',
        }).then((result) => {
            if (result.isConfirmed) {
                typeof confirmCall == 'function' && confirmCall();
            } else if (result.isDenied) {
            }
        })
    },
    // 重定向后闪存的提示
    toastrInfo(msg) {
        toastr.options = {
            "positionClass": "toast-top-center",
            "timeOut": 10000,
        };
        toastr.warning(msg);
    },
    initMagnific() {
        $('.magnific-popup').magnificPopup({type: 'image'});
    },
    initTooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    },
    init() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        this.initMagnific();
        this.initTooltip();
    },
};

YY.init();
