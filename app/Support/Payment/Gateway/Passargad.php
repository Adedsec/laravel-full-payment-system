<?php

namespace App\Support\Payment\Gateway;

use App\Order;
use Illuminate\Http\Request;

class Passargad implements GatewayInterface
{
    public function pay(Order $order, $amount)
    {
        dd('Passargad Pay');
    }
    public function verify(Request $request)
    {
    }
    public function getName(): string
    {
        return "avvv";
    }
}
