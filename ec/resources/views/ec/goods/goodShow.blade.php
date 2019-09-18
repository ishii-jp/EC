@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <h4>{{ $good->name }}の詳細</h4>
    <table class="table table-striped">
        <tr><th>商品名</th><th>カテゴリー</th><th>メーカー</th><th>値段</th><th>在庫</th></tr>
        <tr>
            <td>{{ $good->name }}</td>
            <td><a href="{{ route('categoryShow', $good->category_id) }}">{{ $good->category->category_name }}</a></td>
            <td>{{ $good->maker->maker_name }}</td>
            <td>￥{{ $good->price }}</td>
            <td>{{ $good->stock }}</td>
        </tr>
    </table>
    <span>商品説明</span>
    <p>{{ $good->good_details }}</p>
    <!-- この辺りに商品イメージ画像を表示できるようにする。 -->
    <form action="{{ route('cartConfirm') }}" method="post">
        @csrf
        <p><button class="btn btn-primary btn-sm" type="submit" name="good_id" value="{{ $good->id }}">カートへ入れる</button></p>
    </form>
    <a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">前へ戻る</button></a>
</div>
@endsection