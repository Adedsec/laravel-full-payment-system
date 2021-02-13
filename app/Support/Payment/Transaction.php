<?php

namespace App\Support\Payment;

use App\Events\OrderRegistered;
use App\Order;
use App\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Support\Basket\Basket;
use App\Support\Cost\Contracts\CostInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Support\Payment\Gateway\Saman;
use App\Support\Payment\Gateway\Passargad;
use App\Support\Payment\Gateway\GatewayInterface;

class Transaction
{
    private $request;
    private $basket;
    private $cost;

    public function __construct(Request $request, Basket $basket, CostInterface $cost)
    {
        $this->request = $request;
        $this->basket = $basket;
        $this->cost = $cost;
    }

    public function checkout()
    {

        DB::beginTransaction();

        try {
            $order = $this->makeOrder();

            $order->generateInvoice();


            $payment = $this->makePayment($order);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            dd($e);
            return null;
        }


        if ($payment->isOnline()) {
            return $this->gatewayFactory()->pay($order, $this->cost->getTotalCost());
        }

        $this->completeOrder($order);


        return $order;
    }

    public function verify()
    {
        $result = $this->gatewayFactory()->verify($this->request);
        if ($result['status'] == GatewayInterface::TRANSACTION_FAILED) return false;
        $this->confirmPayment($result);
        $this->completeOrder($result['order']);
        return true;
    }

    private function completeOrder($order)
    {
        $this->normalizeQuantity($order);

        event(new OrderRegistered($order));

        $this->basket->clear();

        session()->forget('coupon');
    }


    private function normalizeQuantity($order)
    {
        foreach ($order->products as $product) {
            $product->decrementStock($product->pivot->quantity);
        }
    }


    private function confirmPayment($result)
    {
        return $result['order']->payment->confirm($result['refNum'], $result['gateway']);
    }

    private function gatewayFactory()
    {
        $gateway = [
            'saman' => Saman::class,
            'passargad' => Passargad::class
        ][$this->request->gateway];

        return resolve($gateway);
    }

    private function makeOrder()
    {
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'code' => bin2hex(Str::random(16)),
            'amount' => $this->basket->subTotal()
        ]);

        $order->products()->attach($this->products());

        return $order;
    }

    private function makePayment(Order $order)
    {
        return Payment::create([
            'order_id' => $order->id,
            'method' => $this->request->get('method'),
            'amount' => $this->cost->getTotalCost()
        ]);
    }

    private function products()
    {
        foreach ($this->basket->all() as $product) {
            $products[$product->id] = ['quantity' => $product->quantity];
        }
        return $products;
    }
}
