@extends('layouts.app')

@section('content')

<div class="row mt-5">
    <div class="col-md-8">
        <div class="card text-right">
            <div class="card-header">
                @lang('payment.user information')
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">@lang('payment.grabber') : {{ Auth::user()->name }}</li>
                    <li class="list-group-item">@lang('payment.address') : {{ Auth::user()->address }}</li>
                    <li class="list-group-item">@lang('payment.phone number') : {{ Auth::user()->phone_number }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @include('summary')
            <button href="" type="submit" form="checkout-form"  class="btn mt-4 btn-primary btn-lg w-100 d-block"> @lang('payment.checkout')</button>
    </div>

</div>
<div class="row">
    <div class="col-md-8">
        <div class="card text-right">
            <div class="card-header">@lang('payment.pay ways')</div>
            <div class="card-body">
                <form action="{{ route('basket.checkout') }}" method="post" id="checkout-form">
                    @csrf
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="custom-control align-baseline  col-md-6 ">
                                <input type="radio" id="online" value="online" name="method" class="radio-inline ">
                                <label for="online" class="">
                                    @lang('payment.online pay')
                                </label>
                            </div>

                            <select name="gateway" class=" mb-2 custom-select custom-control-inline">
                                <option value="saman">@lang('payment.saman')</option>
                                <option value="passargad">@lang('payment.pasargad')</option>
                            </select>
                        </li>
                        <li class="list-group-item mt-2">
                            <div class="custom-control align-baseline  col-md-6 ">
                                <input type="radio" id="cash" value="cash" name="method" class=" radio-inline">
                                <label for="cash" class="">
                                    @lang('payment.offline pay')
                                </label>
                            </div>

                            <p class=" text-muted small">
                                @lang('payment.home pay')
                            </p>
                        </li>
                        <li class="list-group-item mt-2">
                            <div class="custom-control align-baseline  col-md-6 ">
                                <input type="radio" id="cart" value=cart" name="method" class=" radio-inline">
                                <label for="cart" class="">
                                    @lang('payment.cart pay')
                                </label>
                            </div>

                            <p class=" text-muted small">
                                @lang('payment.cart pay text')
                            </p>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
