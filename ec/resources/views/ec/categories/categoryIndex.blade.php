@extends('layouts.app')
@section('content')
<div class="container">
    <h4>カテゴリ一覧画面</h4>
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <ul>
        @foreach ($categories as $category)
            <li><a href="{{ route('category.category_id', $category->id) }}">{{ $category->category_name }}</a></li>
        @endforeach
    </ul>
    <a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">商品一覧へ戻る</button></a>
    @include('ec.elements.goodsRanking')
</div>
@endsection