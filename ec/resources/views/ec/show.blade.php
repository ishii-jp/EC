@extends('layouts.app')
@section('content')
<div class="container">
    商品一覧画面
    <form action="{{ route('cartConfirm') }}" method="post">
        @csrf
        <table class="table table-striped">
            <tr><th>商品名</th><th>値段</th><th>在庫</th><th></th></tr>
            @foreach ($goods as $good)
                <tr>
                    <th>{{ $good->name }}</th>
                    <th>￥{{ $good->price }}</th>
                    <th>{{ $good->stock }}</th>
                    <th><button class="btn btn-primary btn-sm" type="submit" name="good_id" value="{{ $good->id }}">カートへ入れる</button></th>
                </tr>
            @endforeach
        </table>
    </form>
    <a href="{{ route('top') }}">前へ戻る</a>
</div>
@endsection