@extends('admin1.layout.base')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">商品列表</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        <div class="">
            <a href="{{ url('/admin/goodEdit') }}" class="btn btn-info">新增</a>
        </div>
    </div>

    <!-- Content Row -->

    <form class="form-inline mb-3">
        <div class="form-group">
            <label>商品标题</label>
            <input type="text" name="title" class="form-control mx-sm-3" placeholder="请输入商品标题" value="{{ $title }}">
        </div>

        <div class="form-group">
            <label>标签</label>
            <select name="label" class="form-control mx-sm-3">
                <option value="">请选择</option>
                @foreach ($labelRel as $k => $v)
                <option value="{{ $k }}" {{ !empty($label) && $k == $label ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-sm"></i></button>
        </div>
    </form>

    <table class="table table-bordered form-table mb-3">
        <thead>
            <tr>
                <th scope="col" width="60">ID</th>
                <th scope="col" width="140">商品图片</th>
                <th scope="col" width="35%">商品标题</th>
                <th scope="col" width="10%">价格</th>
                <th scope="col" width="15%">标签</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
            <tr data-id="{{ $item->id }}">
                <td>{{ $item->id }}</td>
                <td>
                    <a href="{{ $item->cover }}" class="magnific-popup">
                        <img src="{{ $item->cover }}" class="rounded good-img">
                    </a>
                </td>
                <td class="break-line">
                    <div class="text-dark">{{ $item->title }}</div>
                    <div class="text-secondary small">{{ $item->title_sub }}</div>
                </td>
                <td>
                    ￥ {{ $item->amount }}
                </td>

                <td>
                    @foreach ($item->label_arr as $label_item)
                    <span class="badge badge-secondary badge-font">{{ $label_item }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ url('/admin/goodEdit?') . http_build_query(['good_id' => $item->id]) }}" class="btn btn-info">编辑</a>
                    <button type="button" class="btn btn-danger del-btn">删除</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="float-right">
    @include('admin1.layout.page', ['paginator' => $list->appends($search_data)])
    </div>
</div>
@endsection

@section('foot_js')
@parent
<script>
    $('.del-btn').click(function () {
        const $btn = $(this);
        const order_no = $btn.closest('tr').data('id');

        YY.swalConfirm('确定删除此商品吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/admin/goodDel',
                data: {order_no},
                success: (res) => {
                    if (res.code) {
                        $btn.prop('disabled', false);
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
        });
    });
</script>
@endsection
