<table>
    <tr><th>人気商品ランキング</th><th></th></tr>
    <tr><th>順位</th><th>商品名</th></tr>
    @foreach ($goodsRanking as $key => $ranking)
        <tr>
            <td>{{$key + 1}}</td>
            <td><a href="{{ route('goodShow',$ranking->good->id) }}">{{$ranking->good->name}}</a></td>
        </tr>
    @endforeach
</table>