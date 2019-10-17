<h5><a href="{{ route('cartShow') }}">カート一覧</a></h5>
<table class="table table-striped">
    <tr><th>商品名</th><th>値段</th><th>購入数</th></tr>
    @foreach (Cart::content() as $cartContent)
        <tr>
            <td>{{ $cartContent->name }}</td>
            <td>￥{{ $cartContent->price }}</td>
            <td>{{ $cartContent->qty }}</td>
        </tr>
    @endforeach
</table>
<p>カート内合計￥{{ Cart::total() }}</p>

<p><a href="{{ route('payIndex') }}"><button class="btn btn-primary btn-sm" type="button">お会計へ進む</button></a></p>