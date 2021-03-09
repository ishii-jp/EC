@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <p><a href="{{ route('category') }}">カテゴリー一覧画面へ戻る</a></p>

    <!-- カテゴリ一覧表示 -->
    @include('ec.elements.showTable')
    <!-- カテゴリ一覧表示 -->

    <!-- 商品ランキング表示 -->
    @include('ec.elements.goodsRanking')
    <!-- 商品ランキング表示 -->

    <!-- カテゴリ別商品ランキング表示 -->
    @include('ec.elements.good_ranking_by_category')
    <!-- カテゴリ別商品ランキング表示 -->
</div>
@endsection