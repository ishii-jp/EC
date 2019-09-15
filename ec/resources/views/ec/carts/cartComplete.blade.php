@extends('layouts.app')
@section('content')
<div class="container">
    <p>{{ $good_name }}を{{ $number }}個カートに追加しました。</p>
    <p><a href="{{ route('top') }}">トップはこちら</a><p>
    <p><a href="{{ route('show') }}">引き続きお買い物をする方はこちら</a><p>
</div>
@endsection