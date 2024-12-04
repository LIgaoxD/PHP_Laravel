<!-- 继承自名为 'shop1.layout.base' 的模板 -->
@extends('shop1.layout.base')

<!-- 开始定义一个名为 'content' 的占位区域 -->
@section('content')

<!-- 顶部区域，包含了一个背景图片和一些文本 -->
<div class="position-relative overflow-hidden text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5" style="color: black;">
        <!-- 大标题 -->
        <h1 class="display-5 font-weight-normal" style="margin-bottom: 16px;">购你所需</h1>
        <!-- 副标题 -->
        <h6 class=" font-weight-normal">秋季限定 🌼 全场购物满 ￥666 享9折</h6>
    </div>
</div>

{{--
<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3"> 
<div class="row w-100 my-md-3">
    @foreach ($list as $item)
    <div class="bg-light pt-3 px-3 pt-md-3 px-md-5 text-center overflow-hidden col-md-6 mb-2">
        <div class="p-3">
            <!-- 商品标题 -->
            <h2 class="display-5 line-1">
                <a href="{{ '/good/detail?' . http_build_query(['good_id' => $item->id]) }}" class="pure-link text-dark">{{ $item->title }}</a>
</h2>
<div class="lead">
    <!-- 商品标签 -->
    @foreach ($item->label_arr as $label_item)
    <span class="badge badge-secondary badge-font">{{ $label_item }}</span>
    @endforeach
</div>
<div class="lead">￥{{ $item->amount }}</div>
</div>
<!-- 商品图片 -->
<div class="mx-auto" style="width: 80%; height: 300px;">
    <img src="{{ $item->cover }}" class="mw-100 mh-100 shadow-sm" style="border-radius: 8px 8px 0 0;">
</div>
</div>
@endforeach
</div>
--}}

<!-- 标签选择表单 -->
<div class="d-flex justify-content-center align-items-center mt-4 mb-4">
    <form class="form-inline">
        @foreach ($labelRel as $k => $v)
        <div class="form-check form-check-inline">
            <!-- 标签单选按钮 -->
            <input class="form-check-input" type="radio" name="label" id="inlineRadio{{ $k }}" value="{{ $k }}" {{ $k == $label ? 'checked' : '' }}>
            <label class="form-check-label" for="inlineRadio{{ $k }}" style="margin-right: 24px;color:black;">{{ $v }}</label>
        </div>
        @endforeach
        <div class="form-group">
            <!-- 提交按钮 -->
            <button type="submit" class="btn btn-outline-primary" style="margin: 12px 36px 12px 36px; color:black;"><i class="fas fa-search fa-sm"></i> 标签筛选</button>
        </div>
    </form>
</div>

<!-- 商品列表区域 -->
<div class="container">
    <div class="row">
        @foreach ($list as $item)
        <div class="col-md-4">
            <div class="text-center border overflow-hidden mb-3" style="color: black;">
                <div class="py-3">
                    <h3 class="display-5 line-1 mb-0">
                        <a href="{{ '/good/detail?' . http_build_query(['good_id' => $item->id]) }}" class="pure-link text-dark">{{ $item->title }}</a>
                    </h3>
                    <div class="lead mb-1">
                        @foreach ($item->label_arr as $label_item)
                        <span class="badge badge-secondary badge-font">{{ $label_item }}</span>
                        @endforeach
                    </div>
                    <div class="lead">
                        <span class="price-sign">￥</span>
                        {{ $item->amount }}
                    </div>
                </div>
                <div class="mx-auto" style="width: 80%; height: 300px;">
                    <a href="{{ '/good/detail?' . http_build_query(['good_id' => $item->id]) }}" class="pure-link text-dark">
                        <img src="{{ $item->cover }}" class="mw-100 mh-100 shadow-sm" style="border-radius: 8px 8px 8px 8px; width: 200px;height: 240px">
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


<!-- 分页器 -->
<div class="row">
    <div class="mx-auto">
        @include('shop1.layout.page', ['paginator' => $list])
    </div>
</div>

<!-- 结束定义名为 'content' 的占位区域 -->
@endsection