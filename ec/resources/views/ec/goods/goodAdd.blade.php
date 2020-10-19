@extends('layouts.app')
@section('content')
    <div class="container">
    @include('ec.elements.goods.msg')
    @include('ec.elements.exception')
    <h4>新規商品登録</h4>
    @if ($errors->all())
        @foreach ($errors->all() as $message)
            <p style="color:red">{{ $message }}</p>
        @endforeach
    @endif
        <form action="{{ route('good.create') }}" method="POST">
        @csrf
            <table class="table table-striped">
                <tr><th>商品名</th><th>ふりがな</th><th>カテゴリー名</th><th>メーカー名</th><th>値段</th><th>在庫</th><th>商品説明</th></tr>
                    <tr>
                        <td><input type="text" name="name" value="{{ old('name') }}"></td>
                        <td><input type="text" name="kana" value="{{ old('kana') }}"></td>
                        <td>
                            <select name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category') == $category->id) selected='selected' @endif>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="maker_id">
                                @foreach ($makers as $maker)
                                    <option value="{{ $maker->id }}" @if(old('maker') == $maker->id) selected='selected' @endif>{{ $maker->maker_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="price" value="{{ old('price') }}"></td>
                        <td>
                        <select name="stock">
                            @for ($i=1; $i <= 99; $i++)
                                <option value="{{ $i }}" @if(old('stock') == $i) selected='selected' @endif>{{ $i }}</option>
                            @endfor
                        </select>
                        </td>
                        <td><textarea name="good_details" rows="3" cols="60">{{ old('good_details') }}</textarea></td>
                    </tr>
            </table>
            <button type="submit" class="btn btn-primary btn-sm">追加</button>
        </form>
    </div>
@endsection