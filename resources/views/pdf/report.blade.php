@php
    // Ambil report pertama dari collection
    $report = is_array($reports) ? reset($reports) : $reports->first();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - {{ $report->report_date ?? '-' }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.4; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 20px; }
        
        /* Layout Tabel Utama */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; font-size: 11px; text-transform: uppercase; }
        
        /* Penataan Angka */
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        /* Sektor Informasi Ringkas */
        .summary-box { margin-bottom: 20px; width: 100%; }
        .summary-item { display: inline-block; width: 30%; border: 1px solid #ddd; padding: 10px; background: #fff; }

        .footer { margin-top: 30px; font-size: 10px; color: #777; text-align: center; }
        
        /* Warna Khusus Pendapatan */
        .revenue-cell { color: #2d6a4f; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1 style="margin: 0; font-size: 20px;">LAPORAN RINGKASAN HARIAN</h1>
        <p style="margin: 5px 0;">Restoran Ngijo - Tanggal: <strong>{{ $report->report_date }}</strong></p>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <small>TOTAL ORDER</small><br>
            <strong>{{ $report->total_orders }} Pesanan</strong>
        </div>
        <div class="summary-item">
            <small>TOTAL TRANSAKSI</small><br>
            <strong>{{ $report->total_transactions }} Kali</strong>
        </div>
        <div class="summary-item">
            <small>TOTAL PAID (SUKSES)</small><br>
            <strong style="color: #2d6a4f;">Rp {{ number_format($report->total_success_amount, 0, ',', '.') }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Keterangan</th>
                <th class="text-right">Nilai / Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Total Revenue (Potensi Pendapatan)</td>
                <td class="text-right">Rp {{ number_format($report->total_order_revenue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>Total Success Amount (Paid)</strong></td>
                <td class="text-right revenue-cell">Rp {{ number_format($report->total_success_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Total Volume Pesanan</td>
                <td class="text-right">{{ $report->total_orders }} Order</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Total Transaksi Diproses</td>
                <td class="text-right">{{ $report->total_transactions }} Transaksi</td>
            </tr>
        </tbody>
    </table>

    @if($report->total_per_method)
    <h3 style="font-size: 14px; margin-top: 20px;">Breakdown Per Metode:</h3>
    <ul>
        @foreach($report->total_per_method as $method => $amount)
            <li>{{ strtoupper($method) }}: Rp {{ number_format($amount, 0, ',', '.') }}</li>
        @endforeach
    </ul>
    @endif

    <div class="footer">
        <p>Data diambil pada sistem: {{ $report->created_at }}</p>
        <p><em>Dokumen ini sah dihasilkan secara digital oleh Bagian Report (Orang ke-3).</em></p>
    </div>

</body>
</html>