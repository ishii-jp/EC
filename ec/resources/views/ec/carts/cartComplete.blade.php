@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($carts as $cart)
        <p>{{ $cart->name }}を{{ $cart->qty }}個カートに追加しました。</p>
    @endforeach
    <p><a href="{{ route('show') }}">引き続きお買い物をする方はこちら</a><p>
    <p><a href="{{ route('pay') }}">購入はこちら</a><p>
    <p><a href="{{ route('top') }}">トップはこちら</a><p>
</div>
@endsection