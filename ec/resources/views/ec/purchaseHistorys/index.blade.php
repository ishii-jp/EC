@extends('layouts.app')
@section('content')
    <div class="container">
    <p>購入履歴画面</p>
    @if ($purchaseHistories->isEmpty())
        <p>購入履歴はありません</P>
    @else
        <table class="table table-striped">
        <tr><th>商品名</th><th>購入数</th><th>購入日時</th></tr>
        @foreach ($purchaseHistories as $purchaseHistory)
            <tr>
                <td>
                    <a href="{{ route('goodShow',$purchaseHistory->good->id) }}">{{ $purchaseHistory->good->name }}</a>
                </td>
                <td>{{ $purchaseHistory->qty }}</td>
                <td>{{ $purchaseHistory->created_at }}</td>
            </tr>
            @endforeach
        </table>
    @endif
    <a href="{{ route('myPage') }}"><button class="btn btn-primary btn-sm">マイページへ戻る</button></a>
    <div>
@endsection