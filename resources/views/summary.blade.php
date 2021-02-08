@inject('cost', 'APP\Support\Cost\Contracts\CostInterface')
<div class="card bg-light">
    <div class="card-body text-right">
        <h4>@lang('payment.cart summary')</h4>
        <hr>
        <div class="well">
            <table class="table">
                @foreach($cost->getSummary() as $description => $price)
                    <tr>
                        <td>{{ $description }}</td>
                        <td>{{ number_format($price) }} @lang('payment.toman')</td>
                    </tr>
                @endforeach
                <tr>
                    <td>@lang('payment.basket total')</td>
                    <td>{{ number_format($cost->getTotalCost()) }} @lang('payment.toman')</td>

                </tr>
                <tr>
                    <td colspan="2">
                        @if(session()->has('coupon'))
                            <form action="{{ route('coupons.remove') }}" method="GET">
                                @csrf
                                <div class="input-group d-flex align-items-center justify-content-between">
                                    <span class="mt-2">{{ session()->get('coupon')->code }}</span>
                                    <span class=" input-group-append">
                                        <button class="btn btn-primary mr-3" type="submit"> @lang('payment.remove') </button>
                                    </span>
                                </div>
                            </form>
                        @else

                        <form action="{{ route('coupons.store') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="coupon" class="form-control" id="coupon">
                                <span class=" input-group-btn">
                                    <button class="btn btn-primary mr-3" type="submit"> @lang('payment.apply') </button>
                                </span>
                            </div>
                        </form>

                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
