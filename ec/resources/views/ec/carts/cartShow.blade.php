@extends('layouts.app')
@section('content')
<div class="container">
    <h5>カート一覧</h5>
    <form action="{{ route('cartDelete') }}" method="post">
        @csrf
        {{ method_field('delete') }}
        <table class="table table-striped">
            <tr><th>商品名</th><th>値段</th><th>購入数</th><th></th></tr>
            @foreach (Cart::content() as $cartContent)
                <tr>
                    <td>{{ $cartContent->name }}</td>
                    <td>{{ $cartContent->price }}</td>
                    <td>{{ $cartContent->qty }}</td>
                    <td><a href="{{ route('cartDelete') }}"><button class="btn btn-primary btn-sm" type="submit" name ="rowId" value="{{ $cartContent->rowId }}">削除</button></a></td>
                </tr>
            @endforeach
        </table>
    </form>
    <p>カート内合計￥{{ Cart::total() }}</p>

    <p><a href=""><button class="btn btn-primary btn-sm" type="button">お会計へ進む</button></a></p><!-- 決済へのリンクをはる -->
    <form action="{{ route('cartReset') }}" method="post">
        @csrf
        {{ method_field('delete') }}
        <p><button class="btn btn-primary btn-sm" type="submit">カートを空にする</button></p>
    </form>
</div>
@endsection