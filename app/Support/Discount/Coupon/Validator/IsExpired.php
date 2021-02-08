<?php

namespace App\Support\Discount\Coupon\Validator;

use App\Coupon;
use App\Exceptions\CouponHasExpired;
use App\Support\Discount\Coupon\Validator\Contracts\AbstractCouponValidator;

class IsExpired extends AbstractCouponValidator

{
    public function validate(Coupon $coupon)
    {
        if ($coupon->isExpired()) {
            throw new CouponHasExpired();
        }

        return parent::validate($coupon);
    }
}
