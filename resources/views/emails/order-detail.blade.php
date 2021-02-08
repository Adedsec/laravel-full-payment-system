<h3>جزییات سفارش</h3>

سفارش با شماره
{{ $order->id }}
ثبت شد .

لیست سفارش شما به صورت زیر است :

<ul>
    @foreach($order->products as $product)
        <li>{{ $product->title }}</li>
    @endforeach
</ul>
