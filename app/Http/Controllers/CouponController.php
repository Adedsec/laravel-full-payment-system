<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Support\Discount\Coupon\Validator\CouponValidator;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $validator;

    public function __construct(CouponValidator $validator)
    {
        $this->middleware('auth');
        $this->validator = $validator;
    }


    public function store(Request $request)
    {

        try {
            $request->validate(
                [
                    'coupon' => ['required', 'exists:coupons,code']
                ]
            );

            $coupon = Coupon::where('code', $request->get('coupon'))->firstOrFail();

            $this->validator->isValid($coupon);

            session()->put('coupon', $coupon);
            return redirect()->back()->withSuccess('کدتخفیف با موفقیت اعمال شد ');
        } catch (\Throwable $th) {

            return redirect()->back()->withError('کد تخفیف نامعتبر است');
        }
    }

    public function remove()
    {
        session()->forget('coupon');

        return back();
    }
}
