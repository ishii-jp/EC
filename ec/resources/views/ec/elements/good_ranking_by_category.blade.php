@if (count($goodsRankingByCategory) > 0)
<table>
    <tr><th>カテゴリ別人気商品ランキング</th><th></th></tr>
    <tr><th>順位</th><th>商品名</th></tr>
    @foreach ($goodsRankingByCategory as $key => $ranking)
        <tr>
            <td>{{$key + 1}}</td>
            <td><a href="{{ route('good.good_id',$ranking['good_id']) }}">{{ $ranking['good']['name'] }}</a></td>
        </tr>
    @endforeach
</table>
@else
<p>カテゴリ別ランキングはありません</p>
@endif