@extends('layouts.app')
@section('content')
<div class="container">
    @if (Cart::count() > 0)
        @include('ec.elements.carts.index')
    @endif
    @include('ec.elements.showTable')
</div>
@endsection