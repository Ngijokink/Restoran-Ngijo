<!DOCTYPE html>
<html>
<head>
    <title>Daily Statistics</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Order Statistics - {{ $date }}</h2>
<table>
    <thead>
        <tr>
            <th>Menu</th>
            <th>Total Order</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orderStats as $item)
        <tr>
            <td>{{ $item->menu_name }}</td>
            <td>{{ $item->total_order }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Transaction Statistics - {{ $date }}</h2>
<table>
    <thead>
        <tr>
            <th>Menu</th>
            <th>Total Transaction</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactionStats as $item)
        <tr>
            <td>{{ $item->menu_name }}</td>
            <td>{{ $item->total_transaction }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>