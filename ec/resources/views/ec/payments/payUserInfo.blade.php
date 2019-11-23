@extends('layouts.app')
@section('content')
<div class="container">
@if (Request::is('pay/userInfo'))
    <p>お客様情報を入力してください。</p>
    @include('ec.elements.forms.userInfoForm')
@else
    @include('ec.elements.forms.userInfoFormConfirm')
@endif

</div>
@endsection