@extends('shop1.layout.base')

@section('content')
<div class="container mx-auto py-3 py-md-5 my-3">
    <div class="row">
        <div class="col-md-4">
            <a href="{{ $rs['cover'] }}" class="magnific-popup">
                <img src="{{ $rs['cover'] }}" style="max-height: 400px; max-width: 100%;">
            </a>
        </div>
        
        <div class="col-md-8" style="position: relative;">
            <h2 class="mb-2">{{ $rs['title'] }}</h2>
            <div class="mb-2 text-muted">{{ $rs['title_sub'] }}</div>
            <div class="lead mb-2">
                @foreach ($rs['label_arr'] as $label_item)
                <span class="badge badge-secondary badge-font">{{ $label_item }}</span>
                @endforeach
            </div>
            <div class="lead">
                <span class="price-sign">￥</span>
                {{ $rs['amount'] }}
            </div>

            <div style="position: absolute; bottom: 0;" class="toolbar" data-id="{{ $rs['id'] }}">
                @if ($rs['is_like'])
                <button type="button" class="btn btn-secondary like-btn" data-yes="0">取消点赞</button>
                @else
                <button type="button" class="btn btn-info like-btn" data-yes="1"><i class="fas fa-thumbs-up"></i> 点赞</button>
                @endif
                @if ($rs['is_collect'])
                <button type="button" class="btn btn-secondary ml-2 collect-btn" data-yes="0">取消收藏</button>
                @else
                <button type="button" class="btn btn-info ml-2 collect-btn" data-yes="1"><i class="fas fa-heart"></i> 收藏</button>
                @endif
                <button type="button" class="btn btn-warning ml-2 cart-btn"><i class="fas fa-plus"></i>加入购物车</button>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('foot_js')
@parent
<script>
    $('.like-btn').click(function() {
        const $btn = $(this);
        const btn_info = $btn.text().trim();
        const good_id = $btn.closest('.toolbar').data('id');
        const is_yes = $btn.data('yes');

        YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/like',
                data: {
                    good_id,
                    is_yes
                },
                success: (res) => {
                    if (res.code) {
                        $btn.prop('disabled', false);
                        return YY_FRONT.alertError(res.msg);
                    }
                    YY_FRONT.alertSuccess(res.msg, function() {
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

    $('.collect-btn').click(function() {
        const $btn = $(this);
        const btn_info = $btn.text().trim();
        const good_id = $btn.closest('.toolbar').data('id');
        const is_yes = $btn.data('yes');

        YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/good/collect',
                data: {
                    good_id,
                    is_yes
                },
                success: (res) => {
                    if (res.code) {
                        $btn.prop('disabled', false);
                        return YY_FRONT.alertError(res.msg);
                    }
                    YY_FRONT.alertSuccess(res.msg, function() {
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

    $('.cart-btn').click(function() {
        const $btn = $(this);
        const btn_info = $btn.text();
        const good_id = $btn.closest('.toolbar').data('id');
        const good_num = 1;

        // YY_FRONT.swalConfirm('确定要' + btn_info + '吗？', () => {
        $btn.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: '/good/addCart',
            data: {
                good_id,
                good_num
            },
            success: (res) => {
                if (res.code) {
                    $btn.prop('disabled', false);
                    return YY_FRONT.alertError(res.msg);
                }
                YY_FRONT.alertSuccess(res.msg, function() {
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