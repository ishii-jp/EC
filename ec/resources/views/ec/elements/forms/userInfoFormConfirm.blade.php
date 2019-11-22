<form action="{{ route($formAction) }}" method="POST">
    @csrf
    <table class="table table-striped">
        <tr>
            <th>氏名</th>
            <td><input type="text" name="userInfo[name]" value="{{ $formValue['userInfo']['name'] }}" readonly></td>
        </tr>
        <tr>
            <th>郵便番号</th>
            <td><input type="text" name="userInfo[zip]" value="{{ $formValue['userInfo']['zip'] }}" readonly></td>
        </tr>
        <tr>
            <th>住所</th>
            <td><input type="text" name="userInfo[address]" value="{{ $formValue['userInfo']['address'] }}" readonly></td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td><input type="text" name="userInfo[tel]" value="{{ $formValue['userInfo']['tel'] }}" readonly></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><input type="text" name="userInfo[mail]" value="{{ $formValue['userInfo']['mail'] }}" readonly></td>
        </tr>
        <tr>
            <th>メールアドレス(確認用)</th>
            <td><input type="text" name="userInfo[mail_confirmation]" value="{{ $formValue['userInfo']['mail_confirmation'] }}" readonly></td>
        </tr>
    </table>
    <button class="btn btn-primary btn-sm" name="back" value="修正する" type="submit">修正する</button>
    <button class="btn btn-primary btn-sm" name="complete" value="登録" type="submit">登録</button>
</form>