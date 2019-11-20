@if ($errors->any())
    @foreach ($errors->all() as $error)
    <p style="color:red">エラーメッセージ：{{ $error }}</p>
    @endforeach
@endif
<form action="{{ route($formAction) }}" method="POST">
    @csrf
    <table class="table table-striped">
        <tr>
            <th>氏名</th>
            <td><input type="text" name="userInfo[name]" value="{{ old('userInfo.name') }}"></td>
        </tr>
        <tr>
            <th>郵便番号</th>
            <td><input type="text" name="userInfo[zip]" value="{{ old('userInfo.zip') }}"></td>
        </tr>
        <tr>
            <th>住所</th>
            <td><input type="text" name="userInfo[address]" value="{{ old('userInfo.address') }}"></td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td><input type="text" name="userInfo[tel]" value="{{ old('userInfo.tel') }}"></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><input type="text" name="userInfo[mail]" value="{{ old('userInfo.mail') }}"></td>
        </tr>
        <tr>
            <th>メールアドレス(確認用)</th>
            <td><input type="text" name="userInfo[mail_confirmation]" value="{{ old('userInfo.mail_confirmation') }}"></td>
        </tr>
    </table>
    <button class="btn btn-primary btn-sm" type="submit">確認</button>
</form>