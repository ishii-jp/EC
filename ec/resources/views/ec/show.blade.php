@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <h3>商品一覧</h3>
    <p><a href="{{ route('categoryIndex') }}">カテゴリーごとにみる</a></p>
    @include('ec.elements.showTable')
    <a href="{{ route('top') }}"><button class="btn btn-primary btn-sm" type="button">前へ戻る</button></a>
</div>
@endsection