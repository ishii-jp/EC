@extends('layouts.app')
@section('content')
<div class="container">
    <p><a href="{{ route('good.add') }}">新規商品登録はこちら</a></p>
    <p><a href="">新規カテゴリー登録はこちら</a></p>
    <p><a href="">新規メーカー登録はこちら</a></p>
    <h4>現在の取り扱い商品一覧</h4>
    @if (isset($goods))
    @include('ec.elements.goods.msg')
    @include('ec.elements.exception')
    <form action="{{ route('good.update') }}" method="POST">
        @csrf
        <table class="table table-striped">
            <tr><th>商品名</th><th>ふりがな</th><th>カテゴリー名</th><th>メーカー名</th><th>値段</th><th>在庫</th><th>商品説明</th></tr>
            @foreach ($goods as $good)
                <tr>
                    <td><input type="text" name="goods[name][{{ $good->id }}]" value="{{ old('name', $good->name) }}"></td>
                    <td><input type="text" name="goods[kana][{{ $good->id }}]" value="{{ old('kana', $good->kana) }}"></td>
                    <td>
                        <select name="goods[category][{{ $good->id }}]">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if($good->category->id == $category->id) selected='selected' @endif>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="goods[maker][{{ $good->id }}]">
                            @foreach ($makers as $maker)
                                <option value="{{ $maker->id }}" @if($good->maker->id == $maker->id) selected='selected' @endif>{{ $maker->maker_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="goods[price][{{ $good->id }}]" value="{{ old('price', $good->price) }}"></td>
                    <td>
                    <select name="goods[stock][{{ $good->id }}]">
                        @for ($i=1; $i <= 99; $i++)
                            <option value="{{ $i }}" @if($good->stock == $i) selected='selected' @endif>{{ $i }}</option>
                        @endfor
                    </select>
                    </td>
                    <td><textarea name="goods[good_details][{{ $good->id }}]" rows="3" cols="60">{{ old('good_details', $good->good_details) }}</textarea></td>
                </tr>
            @endforeach
        </table>
        <button type="submit" class="btn btn-primary btn-sm">送信</button>
    </form>
    @else
    <p>現在取り扱っている商品はありません。</p>
    @endif
    <!-- この辺りに商品イメージ画像を表示できるようにする。 -->
    <a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">前へ戻る</button></a>
</div>
@endsection