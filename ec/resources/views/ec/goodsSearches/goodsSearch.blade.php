@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <h3>商品検索結果</h3>

    {{-- 商品検索 --}}
    @include('ec.elements.goodsSearch')
    {{-- 商品検索 --}}

    <p><a href="{{ route('category') }}">カテゴリーごとにみる</a></p>
    @include('ec.elements.showTable')
    <a href="{{ route('top') }}"><button class="btn btn-primary btn-sm" type="button">トップへ戻る</button></a>
    @include('ec.elements.goodsRanking')
</div>
@endsection