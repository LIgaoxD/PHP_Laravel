@extends('admin1.layout.base')

@section('head_css')
@parent
<link href="/jQuery-File-Upload-10.32.0/css/jquery.fileupload.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $h_title }}</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row pb-4">
        <div class="col-md-6">
            <form class="" id="save-form">
                @if(!empty($data_good['id']))
                    <input type="hidden" name="good_id" value="{{ $data_good['id'] }}">
                @endif
                <div class="form-group">
                    <label>商品标题</label>
                    <input type="text" name="title" class="form-control"
                        placeholder="请输入商品标题" value="{{ $data_good['title'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>商品副标题</label>
                    <textarea name="title_sub" class="form-control" rows="2" placeholder="请输入商品副标题">{{ $data_good['title_sub'] ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="cover" value="{{ $data_good['cover'] ?? '' }}">
                    <label>商品图片</label>
                    <div>
                        <button type="button" class="btn btn-info fileinput-button">
                            <input class="upload-btn" type="file" name="file" accept=".jpg,.jpeg,.png,.gif">
                            <span>上传图片</span>
                        </button>
                    </div>
                    <div class="mt-3">
                        <a href="{{ $data_good['cover'] ?? '' }}" class="magnific-popup {{ $data_good['cover'] ?? 'd-none' }}">
                            <img src="{{ $data_good['cover'] ?? '' }}" class="good-img" id="good-img-id">
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
                            placeholder="请输入商品价格" value="{{ $data_good['amount'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group" hidden>
                    <label>商品分类</label>
                    <select name="cate" class="form-control">
                        @foreach ($cateRel as $k => $v)
                        <option value="{{ $k }}" {{ isset($data_good['cate']) && $data_good['cate'] == $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>商品标签</label>
                    <select name="label[]" class="form-control" multiple>
                        @foreach ($labelRel as $k => $v)
                        <option value="{{ $k }}" {{ isset($data_good['label_data']) && in_array($k, $data_good['label_data']) ? 'selected' : '' }}>{{ $v }}</option>
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
                        location.href = '{!! url()->previous() !!}';
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
                    location.href = '{!! url()->previous() !!}';
                }
            });
        },
    });
</script>
@endsection
