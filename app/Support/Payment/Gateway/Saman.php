<?php

namespace App\Support\Payment\Gateway;

use App\Order;
use Illuminate\Http\Request;

class Saman implements GatewayInterface
{

    private $merchentID;
    private $callback;

    public function __construct()
    {
        $this->merchentID = '454214151245';
        $this->callback = route('payment.verify', $this->getName());
    }


    public function pay(Order $order, $amount)
    {
        //dd('saman pay');
        $this->redirectToBank($order, $amount);
    }

    private function redirectToBank(Order $order, $amount)
    {

        echo "<form  id='samanpayment' action='https://sep.shaparak.ir/payment.aspx' method='POST'>
        <input type='hidden' name='Amount' value='{$amount}'/>
        <input type='hidden' name='ResNum' value='{$order->code}'/>
        <input type='hidden' name='RedirectURL' value='{$this->callback}'/>
        <input type='hidden' name='MID' value='{$this->merchentID}'/>
        </form><script>document.forms['samanpayment'].submit()</script>";
    }

    public function verify(Request $request)
    {
        if (!$request->has('status') || $request->input('status') !== "OK") {
            //return $this->transactionFailed();
        }

        $soapClient  = new \SoapClient('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL');

        $response = $soapClient->verifyTransaction($request->input('RefNum'), $this->merchentID);
        $order = $this->getOrder($request->input('ResNum'));

        $response = $order->payment->amount;
        $request->merge(['RefNum' => '45852525']);

        return $response == ($order->payment->amount)
            ? $this->transactionSuccess($order, $request->input('RefNum'))
            : $this->transactionFailed();
    }

    private function getOrder($resNum)
    {
        return Order::where('code', $resNum)->firstOrFail();
    }


    private function transactionSuccess($order, $refNum)
    {
        return [
            'status' => GatewayInterface::TRANSACTION_SUCCESS,
            'order' => $order,
            'refNum' => $refNum,
            'gateway' => $this->getName()
        ];
    }


    private function transactionFailed()
    {
        return [
            'status' => self::TRANSACTION_FAILED
        ];
    }


    public function getName(): string
    {
        return "saman";
    }
}
