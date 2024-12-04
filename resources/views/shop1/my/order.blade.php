@extends('shop1.layout.base')

@section('content')
<div class="position-relative overflow-hidden text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: black;">
        <!-- 大标题 -->
        <h1 class="display-5 font-weight-normal" style="margin-bottom: 24px;">我的订单</h1>
        <!-- 副标题 -->
        <h6 class=" font-weight-normal">HAPPY NEW LIFE</h6>
    </div>
</div>
<div class="container">
    <div class="mb-3">
        <a class="btn {{ in_array($request_path, ['my/index', 'my/edit']) ? 'btn-primary' : 'btn-outline-primary' }}"
            href="/my/index" role="button">基本信息</a>
        <a class="btn {{ $request_path === 'my/order' ? 'btn-primary' : 'btn-outline-primary' }} ml-2"
            href="/my/order" role="button">我的订单</a>
        <a class="btn {{ $request_path === 'my/collect' ? 'btn-primary' : 'btn-outline-primary' }} ml-2"
            href="/my/collect" role="button">我的收藏</a>
        <a class="btn {{ $request_path === 'my/like' ? 'btn-primary' : 'btn-outline-primary' }} ml-2"
            href="/my/like" role="button">我的点赞</a>
    </div>
    <div class="row">
        @forelse ($list as $item)
        <div class="card w-100 mb-3" data-order="{{ $item->order_no }}">
            <div class="card-header d-flex justify-content-between">
                <div>订单编号：<span>{{ $item->order_no }}</span></div>
                <div class="{{ $item->pay_class }} line-initial">{{ $item->pay_txt }}</div>
            </div>
            <div class="card-body">
                @foreach ($item->orderItem as $v_item)
                <div class="media mb-2">
                    <div class="col-md-3 border-right">
                        <a href="{{ $v_item->goodData->cover }}" class="magnific-popup">
                            <img src="{{ $v_item->goodData->cover }}" class="mr-3 rounded" style="max-height: 160px;  max-width: 100%;">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <a href="{{ '/good/detail?' . http_build_query(['good_id' => $v_item->good_id]) }}" class="pure-link text-dark">
                                    {{ $v_item->goodData->title }}
                                </a>
                            </h5>
                            <div>￥{{ $v_item->amount_unit }} x {{ $v_item->num }} = ￥{{ $v_item->amount_sum }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span>订单总计：</span><span>￥{{ $item->amount_total }}</span>
                    </div>
                    @if ($item->is_pay_wait)
                    <button type="button" class="btn btn-outline-primary wait-btn">点击支付</button>
                    @endif
                </div>
                @if ($item->is_pay_yes)
                <div>
                    支付时间：{{ $item->pay_time }}
                </div>
                @endif
            </div>

        </div>
        @empty
        <div class="mx-auto">
            <div>
                <img src="/shop1/img/empty-box.png">
            </div>
            <div class="mt-1 text-center text-info">
                空空如也
            </div>
        </div>
        @endforelse
    </div>
    <div class="row">
        <div class="mx-auto">
        @include('shop1.layout.page', ['paginator' => $list])
        </div>
    </div>
</div>
@endsection

@section('foot_js')
@parent
<script>
    $('.wait-btn').click(function () {
        const $btn = $(this);
        const order_no = $btn.closest('.card').data('order');

        Swal.fire({
            icon: 'question',
            title: '请选择要模拟支付的状态？',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: '模拟【支付成功】',
            denyButtonText: '模拟【支付失败】',
        }).then((result) => {
            let mock_status = -1;
            if (result.isConfirmed) {
                mock_status = 1;
                $btn.prop('disabled', true);
            } else if (result.isDenied) {
                mock_status = 2;
                $btn.prop('disabled', true);
            }

            if (mock_status === -1) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/my/orderPay',
                data: {order_no, mock_status},
                success: (res) => {
                    if (res.code) {
                        $btn.prop('disabled', false);
                        return YY_FRONT.alertError(res.msg);
                    }
                    YY_FRONT.alertSuccess(res.msg, function () {
                        if (res.redirect) {
                            location.href = res.redirect;
                        }
                        if (res.reload) {
                            location.reload();
                        }
                    });
                },
            });
        });
    });
</script>
@endsection
