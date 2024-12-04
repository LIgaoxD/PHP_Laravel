@extends('shop1.layout.base')

@section('content')

<div class="position-relative overflow-hidden text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: black;">
        <!-- 大标题 -->
        <h1 class="display-5 font-weight-normal" style="margin-bottom: 24px;">我的收藏</h1>
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
        <div class="col-md-4 mb-3 card-div" data-id="{{ $item->good_id }}">
            <div class="card" style="width: 18rem;">
                <img src="{{ $item->good_cover }}" class="card-img-top" style="height: 300px;">
                <div class="card-body">
                    <h5 class="card-title line-1"
                        data-toggle="tooltip" data-placement="top" title="{{ $item->good_title }}">{{ $item->good_title }}</h5>
                    <p class="card-text">￥{{ $item->good_amount }}</p>
                     <p class="card-text line-2" style="height: 48px;">{{ $item->good_title_sub }}</p> 
                    <a href="{{ '/good/detail?' . http_build_query(['id' => $item->good_id]) }}" class="btn btn-outline-primary">查看</a>
                    <button type="button" class="btn btn-outline-primary cancel-btn">取消收藏</a>
                </div>
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
    $('.cancel-btn').click(function () {
        const $btn = $(this);
        const good_id = $btn.closest('.card-div').data('id');
        const is_yes = 0;

        YY_FRONT.swalConfirm('确定要取消收藏吗？', () => {
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
</script>
@endsection
