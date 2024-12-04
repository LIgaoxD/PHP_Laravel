@extends('shop1.layout.base')

@section('content')
<div class="container mx-auto py-3 py-md-5 my-3">
    <div class="row">
        <div class="card w-100 mb-3">
            @if (empty($rs['list']))
            <div class="text-center mt-4 mb-2">
                <i class="fas fa-exclamation-circle"></i> 购物车空空如也
            </div>
            <div class="text-center mt-2 mb-4">
                <a href="/" class="btn btn-outline-info">去首页看看</a>
            </div>
            @else
            <div class="card-body">
                @foreach ($rs['list'] as $item)
                <div class="media mb-3">
                    <div class="col-md-3 border-right">
                        <a href="{{ $item['cover'] }}" class="magnific-popup">
                            <img src="{{ $item['cover'] }}" class="mr-3 rounded" style="max-height: 160px; max-width: 100%;">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <a href="{{ '/good/detail?' . http_build_query(['good_id' => $item['id']]) }}" class="pure-link text-dark">
                                    {{ $item['title'] }}
                                </a>
                            </h5>
                            <div>￥{{ $item['price_unit'] }} x {{ $item['num'] }} = ￥{{ $item['price_sum'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div>
                    <span>购物车小计：</span><span>￥{{ $rs['sum'] }}</span>
                </div>
                <button type="button" class="btn btn-outline-primary pay-btn" data-sum="{{ $rs['sum'] }}">点击支付</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('foot_js')
@parent
<script>
    $('.pay-btn').click(function () {
        const $btn = $(this);
        const amount_sum = $btn.data('sum');

        Swal.fire({
            icon: 'question',
            title: '请选择要模拟支付的状态？',
            showDenyButton: true,
            showCancelButton: true,
            denyButtonText: '模拟【支付失败】',
            cancelButtonText: '模拟【等待支付】',
            confirmButtonText: '模拟【支付成功】',
        }).then((result) => {
            let pay_status = -1;
            if (result.isDismissed) {
                pay_status = 0;
                $btn.prop('disabled', true);
            } else if (result.isConfirmed) {
                pay_status = 1;
                $btn.prop('disabled', true);
            } else if (result.isDenied) {
                pay_status = 2;
                $btn.prop('disabled', true);
            }

            if (pay_status === -1) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/good/submit',
                data: {amount_sum, pay_status},
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

    $('.collect-btn').click(function () {
        const $btn = $(this);
        const btn_info = $btn.text();
        const good_id = $btn.closest('.toolbar').data('id');
        const is_yes = $btn.data('yes');

        YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/collect',
                data: {good_id, is_yes},
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

    $('.cart-btn').click(function () {
        const $btn = $(this);
        const btn_info = $btn.text();
        const good_id = $btn.closest('.toolbar').data('id');
        const good_num = 1;

        // YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/addCart',
                data: {good_id, good_num},
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
        // });
    });
</script>
@endsection
