@extends('layouts.app')
@section('content')
<div class="container">
    <p>トップ画面</p>
    <p><a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">商品一覧</button></a></p>
</div>
@endsection