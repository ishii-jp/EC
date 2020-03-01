<p>ユーザー情報</p>
<form action="{{ route($formAction) }}" method="POST">
    @csrf
    <table class="table table-striped">
        <tr>
            <th>氏名</th>
            <td>{{ $formValue['userInfo']['name'] }}</td>
        </tr>
        <tr>
            <th>郵便番号</th>
            <td>{{ $formValue['userInfo']['zip'] }}</td>
        </tr>
        <tr>
            <th>住所</th>
            <td>{{ $formValue['userInfo']['address'] }}</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>{{ $formValue['userInfo']['tel'] }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $formValue['userInfo']['mail'] }}</td>
        </tr>
    </table>

    @if (Request::is('pay/userInfo/confirm') || isset($loginFlg))
        <p>購入商品情報</p>
        <table class="table table-striped">
            @foreach ($cartContents as $cartContent)
                <tr>
                    <th>商品名</th>
                    <td>{{ $goods[$cartContent['id']]->name }}</td>
                </tr>
                <tr>
                    <th>メーカー名</th>
                    <td>{{ $goods[$cartContent['id']]->maker->maker_name }}</td>
                </tr>
                <tr>
                    <th>購入個数</th>
                    <td>{{ $cartContent['qty'] }}</td>
                </tr>
            @endforeach
            <tr>
                <th>お支払額</th>
                <td>¥{{ Cart::total() }}(税込)</td>
            </tr>
        </table>
        <input type="hidden" name="userInfo[name]" value="{{ $formValue['userInfo']['name'] }}">
        <input type="hidden" name="userInfo[zip]" value="{{ $formValue['userInfo']['zip'] }}">
        <input type="hidden" name="userInfo[address]" value="{{ $formValue['userInfo']['address'] }}">
        <input type="hidden" name="userInfo[tel]" value="{{ $formValue['userInfo']['tel'] }}">
        <input type="hidden" name="userInfo[mail]" value="{{ $formValue['userInfo']['mail'] }}">
        <input type="hidden" name="userInfo[mail_confirmation]" value="{{ $formValue['userInfo']['mail_confirmation'] }}">

        <input type="hidden" name="goods[name]" value="{{ $goods[$cartContent['id']]->name }}">
        <input type="hidden" name="goods[maker]" value="{{ $goods[$cartContent['id']]->maker->maker_name }}">
        <input type="hidden" name="goods[stock]" value="{{ $cartContent['qty'] }}">
        @php $buttonValue = '購入'; @endphp
    @else
        @php $buttonValue = '登録'; @endphp
    @endif
    <p>上記お間違いなければ、下記{{ $buttonValue }}ボタンを押してください。</p>
    @isset($loginFlg)
    <button class="btn btn-primary btn-sm" name="back" type="submit" value="戻る">戻る</button>
    @else
        <button class="btn btn-primary btn-sm" name="back" value="修正する" type="submit">修正する</button>
    @endisset

    <button class="btn btn-primary btn-sm" name="complete" value="{{ $buttonValue }}" type="submit">{{ $buttonValue }}</button>
</form>