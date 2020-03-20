<form action="{{ route('goodsSearch') }}" method="POST">
    @csrf
    <label for="goodsSeach">商品検索：</label>
    <input type="text" name="goodsSearch" id="goodsSeach" placeholder="例：テレビ">
    <input type="submit" value="検索">
</form>