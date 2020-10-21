@extends('layouts.app')
@section('content')
<div class="container">
    <p>メーカー新規作成画面</p>
    @if($errors->has('makerName'))
        <p style="color:red">{{$errors->first('makerName')}}</p>
    @endif
    <form action="{{ route('maker.add.post') }}" method="POST">
        @csrf
        <table class="table table-striped">
            <tr>
                <th>新規作成メーカー名</th>
                <td><input type="text" name="makerName" value="{{ old('makerName') }}" placeholder="例）Panasonic"></td>
                <td><button type="submit" class="btn btn-primary btn-sm">送信</button></td>
            </tr>
        </table>
    </form>
    <p><a href="{{ route('good.index') }}">前へ戻る</a></p>
</div>
@endsection
