@extends('admin1.layout.base')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">订单列表</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->

    <form class="form-inline mb-3">
        <div class="form-group">
            <label>订单编号</label>
            <input type="text" name="order_no" class="form-control mx-sm-3" placeholder="请输入订单编号" value="{{ $order_no }}">
        </div>
        <div class="form-group">
            <label>用户名</label>
            <input type="text" name="name" class="form-control mx-sm-3" placeholder="请输入用户名" value="{{ $name }}">
        </div>
        <div class="form-group">
            <label>用户昵称</label>
            <input type="text" name="nickname" class="form-control mx-sm-3" placeholder="请输入用户昵称" value="{{ $nickname }}">
        </div>
        <div class="form-group">
            <label>支付状态</label>
            <select name="pay_status" class="form-control mx-sm-3">
                <option value="">请选择</option>
                @foreach ($payRel as $k => $v)
                <option value="{{ $k }}" {{ is_numeric($pay_status) && $k == $pay_status ? 'selected' : '' }}>{{ $v }}</option>
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
                <th scope="col" width="140">订单编号</th>
                <th scope="col" width="10%">用户名</th>
                <th scope="col" width="35%">订单内容</th>
                <th scope="col" width="10%">总价</th>
                <th scope="col" width="10%">支付状态</th>
                <th scope="col" width="10%">创建时间</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
            <tr data-id="{{ $item->id }}" data-order="{{ $item->order_no }}">
                <td>{{ $item->id }}</td>
                <td>{{ $item->order_no }}</td>
                <td>
                    <div>{{ $item->user_name }}</div>
                    <div class="small badge badge-secondary">{{ $item->user_nickname }}</div>
                </td>
                <td>
                    @foreach ($item->orderItem as $v_item)
                    <div>
                        {{-- <a href="{{ $v_item->goodData->cover }}" class="magnific-popup">
                            <img src="{{ $v_item->goodData->cover }}" class="rounded good-img">
                        </a> --}}
                        <span class="small d-inline-block ellipsis"  style="width: 60%"
                            data-toggle="tooltip" data-placement="top" title="{{ $v_item->goodData->title }}">{{ $v_item->goodData->title }}</span>
                        <span class="small d-inline-block ellipsis ml-1">单价：￥{{ $v_item->amount_unit }}</span>
                        <span class="small d-inline-block ellipsis ml-1">数量：{{ $v_item->num }}</span>
                    </div>
                    @endforeach
                </td>
                <td>￥{{ $item->amount_total }}</td>
                <td>
                    <span class="{{ $item->pay_class }}">{{ $item->pay_str }}</span>
                    @if ($item->is_pay_yes)
                    <div class="small mt-1 text-muted">{{ $item->pay_time }}</div>
                    @endif
                </td>
                <td>{{ $item->create_at }}</td>
                <td>
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
        const order_no = $btn.closest('tr').data('order');

        YY.swalConfirm('确定删除此订单吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/admin/orderDel',
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
