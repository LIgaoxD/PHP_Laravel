@extends('admin1.layout.base')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">修改密码</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-6">
            <form id="save-form">
                <div class="form-group">
                    <input type="password" name="pwd" class="form-control"
                        placeholder="请输入新密码">
                </div>
                <div class="form-group">
                    <input type="password" name="pwd_re" class="form-control"
                        placeholder="请重复新密码">
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block" id="save-btn">
                    保存
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('foot_js')
@parent
<script>
    $('#save-form').submit(() => {
        $('#save-form').ajaxSubmit({
            type: 'POST',
            url: '/admin/pwd',
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
                        location.href = '{!! url()->previous() !!}';
                    }
                });
            },
        });
        return false;
    });
</script>
@endsection
