@extends('layouts.app')
@section('content')
<div class="container">
    <h4>カテゴリ一覧画面</h4>
    <ul>
        @foreach ($categories as $category)
            <li><a href="{{ route('categoryShow', $category->id) }}">{{ $category->category_name }}</a></li>
        @endforeach
    </ul>
    <a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">前へ戻る</button></a>
</div>
@endsection