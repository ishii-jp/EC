@extends('layouts.app')
@section('content')
<div class="container">
    カートに追加する数を選択して下さい。
    <form action="{{ route('cartAdd') }}" method="post">
        @csrf
        <select name="number">
            @php
            for ($i = 0; $i <= 50; $i++){
                echo "<option value=$i>$i</option>";
            }
            @endphp
        </select>

        <p>{{ $good->name }}をカートに追加しますか？</p>

        <input type="hidden" name="good_id" value="{{ $good->id }}">

        <button class="btn btn-primary btn-sm" type="submit" name="action" value="add">はい</button>
        <button class="btn btn-primary btn-sm" type="submit" name="action" value="back">いいえ</button>
    </form>
</div>
@endsection