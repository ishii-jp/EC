<form action="{{ route('cartConfirm') }}" method="post">
    @csrf
    <table class="table table-striped">
        <tr><th>商品名</th><th>値段</th><th>在庫</th><th>詳細</th><th></th></tr>
        @foreach ($goods as $good)
            <tr>
                <td>{{ $good->name }}</td>
                <td>￥{{ $good->price }}</td>
                <td>{{ $good->stock }}</td>
                <td><a href="{{ route('goodShow', ['good_id' => $good->id]) }}"><button class="btn btn-primary btn-sm" type="button">商品詳細</button></a></td>
                <td><button class="btn btn-primary btn-sm" type="submit" name="good_id" value="{{ $good->id }}">カートへ入れる</button></td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
        {{ $goods->links() }}
    </div>
</form>