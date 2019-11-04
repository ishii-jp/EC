@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('pay') }}" method="POST">
    @csrf
        <table class="table table-striped">
            <tr><th>商品名</th><th>値段</th><th>購入数</th></tr>
            @foreach($cartContents as $key => $cartContent)
                <tr>
                    <td>{{ $cartContent->name }}</td>
                    <td>￥{{ $cartContent->price }}</td>
                    <td>{{ $cartContent->qty }}</td>
                </tr>
                <input type="hidden" name="cartContents[{{$key}}][qty]" value="{{ $cartContent->qty }}">
                <input type="hidden" name="cartContents[{{$key}}][id]" value="{{ $cartContent->id }}">
                <input type="hidden" name="cartContents[{{$key}}][rowId]" value="{{ $cartContent->rowId }}">
            @endforeach
        </table>
        <p>合計￥{{ $cartTotal }}です。<br>本当に購入しますか？</p>

        <input type="hidden" value="{{ $cartTotal }}">
            <button class="btn btn-primary btn-sm" type="submit">購入する</button>
            {{-- <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
            </script> --}}
            {{-- <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ env('STRIPE_KEY') }}"
                data-amount={{ $cartTotal }}
                data-name="Stripe Demo"
                data-label="購入をする"
                data-description="Online course about integrating Stripe"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="JPY">
            </script> --}}
    </form>
    <p><a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">戻る</button></a></p>
</div>
@endsection