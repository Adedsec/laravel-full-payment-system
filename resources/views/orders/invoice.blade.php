@inject('cost','App\Support\Cost\Contracts\CostInterface')

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html">
    <title></title>
</head>

<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #dddddd;
    }

    th, td {
        text-align: right;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

    body {
        font-family: sans-serif;
    }
</style>
<body>
<div style="overflow-x: auto;">
    <table>
        <tr>
            <th>نام محصول</th>
            <th>قیمت</th>
            <th>تعداد</th>
            <th>مجموع</th>
        </tr>
        @foreach ($order->products as $product)
            <tr>
                <td>{{$product->title}}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ $product->price * $product->pivot->quantity }}</td>
            </tr>
        @endforeach

        @foreach($cost->getSummary() as $description=>$price)
            <tr>
                <td colspan="3"> {{$description}} </td>
                <td>{{$price}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"> مجموع</td>
            <td>{{$cost->getTotalCost()}}</td>
        </tr>
    </table>
</div>
</body>
</html>
