<?php

namespace App\Support\Payment\Gateway;

use App\Order;
use Illuminate\Http\Request;

interface GatewayInterface
{

    const TRANSACTION_FAILED = 'transaction.failed';
    const TRANSACTION_SUCCESS = 'transaction.succes';

    public function pay(Order $order, $amount);
    public function verify(Request $request);
    public function getName(): string;
}
