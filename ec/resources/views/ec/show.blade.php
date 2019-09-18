@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    <h3>商品一覧</h3>
    <p><a href="{{ route('categoryIndex') }}">カテゴリーごとにみる</a></p>
    <form action="{{ route('cartConfirm') }}" method="post">
        @csrf
        <table class="table table-striped">
            <tr><th>商品名</th><th>値段</th><th>在庫</th><th>詳細</th><th></th></tr>
            @foreach ($goods as $good)
                <tr>
                    <td>{{ $good->name }}</td>
                    <td>￥{{ $good->price }}</td>
                    <td>{{ $good->stock }}</td>
                    <td><a href="{{ route('goodShow', ['good_id' => $good->id]) }}"><button class="btn btn-primary btn-sm" type="button">商品詳細</button></a></td>
                    <td><button class="btn btn-primary btn-sm" type="submit" name="good_id" value="{{ $good->id }}">カートへ入れる</button></td>
                </tr>
            @endforeach
        </table>
    </form>
    <a href="{{ route('top') }}"><button class="btn btn-primary btn-sm" type="button">前へ戻る</button></a>
</div>
@endsection