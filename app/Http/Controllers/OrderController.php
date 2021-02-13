<?php

namespace App\Http\Controllers;

use App\Order;
use App\Support\Payment\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->middleware('auth');
        $this->transaction = $transaction;
    }

    public function index()
    {
        $orders = Auth::user()->orders;
        return view('orders.index', compact('orders'));
    }

    public function pay(Order $order)
    {
        return $this->transaction->pay($order);
    }
}
