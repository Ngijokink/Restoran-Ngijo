<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            background-color: #e8e8e8;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Laporan Report</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal Report</th>
                <th>Total Orders</th>
                <th>Total Order Revenue</th>
                <th>Total Transactions</th>
                <th>Total Success Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->report_date ? $report->report_date->format('d-m-Y') : '-' }}</td>
                    <td>{{ $report->total_orders }}</td>
                    <td>Rp {{ number_format($report->total_order_revenue, 0, ',', '.') }}</td>
                    <td>{{ $report->total_transactions }}</td>
                    <td>Rp {{ number_format($report->total_success_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data report</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
