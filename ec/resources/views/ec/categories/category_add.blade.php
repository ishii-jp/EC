@extends('layouts.app')
@section('content')
<div class="container">
    <p>カテゴリー新規作成画面</p>
    @if($errors->has('categoryName'))
        <p style="color:red">{{$errors->first('categoryName')}}</p>
    @endif
    <form action="{{ route('category.add.post') }}" method="POST">
        @csrf
        <table class="table table-striped">
            <tr>
                <th>新規作成カテゴリー名</th>
                <td><input type="text" name="categoryName" value="{{ old('categoryName') }}" placeholder="例）家電"></td>
                <td><button type="submit" class="btn btn-primary btn-sm">送信</button></td>
            </tr>
        </table>
    </form>
    <p><a href="{{ route('good.index') }}">前へ戻る</a></p>
</div>
@endsection
