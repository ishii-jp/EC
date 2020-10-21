@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <p><a href="{{ route('category') }}">カテゴリー一覧画面へ戻る</a></p>
    @include('ec.elements.showTable')
    @include('ec.elements.goodsRanking')
</div>
@endsection