<?php

namespace App\Http\Controllers;

use App\Support\Payment\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function verify(Request $request)
    {

        return $this->transaction->verify()
            ? $this->sendSuccessResponse()
            : $this->sendErrorResponse();
    }


    private function sendSuccessResponse()
    {
        return redirect()->route('products.index')->with('success', 'سفارش شما با موفقیت انجام شد');
    }


    private function sendErrorResponse()
    {
        return redirect()->route('products.index')->with('error', 'مشکلی هنگام پرداخت به وجود آمده است');
    }
}
