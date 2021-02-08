<?php

namespace App\Support\Discount\Coupon\Validator;

use App\Coupon;
use App\Exceptions\IllegalCouponException;
use App\Support\Discount\Coupon\Validator\Contracts\AbstractCouponValidator;
use Illuminate\Support\Facades\Auth;

class CanUseIt extends AbstractCouponValidator
{
    public function validate(Coupon $coupon)
    {
        if (!Auth::user()->coupons->contains($coupon)) {
            throw new IllegalCouponException();
        }

        return parent::validate($coupon);
    }
}
