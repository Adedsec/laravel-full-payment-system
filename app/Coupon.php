<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int percent
 * @property int limit
 */
class Coupon extends Model
{
    public function isExpired()
    {
        return Carbon::now()->isAfter(Carbon::parse($this->expire_time));
    }
}
