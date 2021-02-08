<?php

namespace App\Support\Discount\Coupon\Validator;

use App\Coupon;

class CouponValidator
{
    public function isValid(Coupon $coupon)
    {
        $isExpired = resolve(IsExpired::class);
        $canUseIt = resolve(CanUseIt::class);

        $isExpired->setNextValidator($canUseIt);

        return $isExpired->validate($coupon);
    }
}
