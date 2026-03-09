<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Report - {{ $report['report_date'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .stats-header {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status-breakdown {
            margin-top: 15px;
        }
        .status-breakdown table {
            width: 100%;
            border-collapse: collapse;
        }
        .status-breakdown th,
        .status-breakdown td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .status-breakdown th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Report</h1>
        <p>Date: {{ \Carbon\Carbon::parse($report['report_date'])->format('F j, Y') }}</p>
    </div>

    <div class="section">
        <h2>Order Statistics</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-header">Total Orders</div>
                <div class="stats-cell">{{ $report['total_orders'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-header">Total Revenue</div>
                <div class="stats-cell">Rp {{ number_format($report['total_order_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="status-breakdown">
            <h3>Order Status Breakdown</h3>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report['order_status_breakdown'] as $status => $count)
                    <tr>
                        <td>{{ $status }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <h2>Transaction Statistics</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-header">Total Transactions</div>
                <div class="stats-cell">{{ $report['total_transactions'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-header">Total Success Amount</div>
                <div class="stats-cell">Rp {{ number_format($report['total_success_amount'], 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="status-breakdown">
            <h3>Total Amount by Payment Method</h3>
            <table>
                <thead>
                    <tr>
                        <th>Payment Method</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report['total_per_method'] as $method => $amount)
                    <tr>
                        <td>{{ $method }}</td>
                        <td>Rp {{ number_format($amount, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>