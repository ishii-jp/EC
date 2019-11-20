@extends('layouts.app')
@section('content')
<div class="container">
<p>お客様情報を入力してください。</p>
    @include('ec.elements.forms.userInfoForm')
</div>
@endsection