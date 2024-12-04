@extends('admin1.layout.base')

@section('content')
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
                        placeholder="请输入站点名称" value="{{ $all_config['site_name'] }}">
                </div>
                <div class="form-group" hidden >
                    <label>站点主题</label>
                    <select name="theme" class="form-control">
                        @foreach ($themeRel as $k => $v)
                        <option value="{{ $k }}" {{ $all_config['theme'] == $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
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
                        location.href = '{!! url()->previous() !!}';
                    }
                });
            },
        });
        return false;
    });
</script>
@endsection
