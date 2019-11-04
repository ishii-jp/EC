@extends('layouts.app')
@section('content')
<div class="container">
    <p>決済処理が完了しました。</p>
    <p><a href="{{ route('top') }}"><button class="btn btn-primary btn-sm" type="button">ホームへ戻る</button></a></p>
    <p><a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">商品一覧へ戻る</button></a></p>
</div>
@endsection