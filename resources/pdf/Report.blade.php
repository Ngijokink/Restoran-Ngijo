<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Summary Report</title>
    <style>
        @page { margin: 40px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
        }
        /* Header Section */
        .header-table { width: 100%; border-bottom: 2px solid #10b981; padding-bottom: 20px; }
        .brand { font-size: 24px; font-weight: bold; color: #064e3b; text-transform: uppercase; }
        .report-title { text-align: right; color: #6b7280; font-size: 14px; }

        /* KPI Cards (Statistik Utama) */
        .kpi-container { margin-top: 30px; width: 100%; }
        .kpi-card {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px;
            width: 30%;
            display: inline-block;
            margin-right: 2%;
        }
        .kpi-title { font-size: 10px; color: #065f46; text-transform: uppercase; letter-spacing: 1px; }
        .kpi-value { font-size: 18px; font-weight: bold; color: #111827; }

        /* Status Breakdown Table */
        .section-title { margin-top: 40px; font-size: 16px; font-weight: bold; border-left: 10px solid #064e3b; padding-left: 10px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f9fafb; color: #4b5563; text-align: left; padding: 12px; font-size: 12px; border-bottom: 1px solid #e5e7eb; }
        td { padding: 12px; font-size: 12px; border-bottom: 1px solid #f3f4f6; }
        
        /* Badge Status */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef9c3; color: #854d0e; }

        /* Top Menu List */
        .top-menu-row:nth-child(even) { background-color: #f9fafb; }
        .revenue-text { color: #10b981; font-weight: bold; }

        /* Footer */
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="brand">Restoran Ngijo <small style="font-size: 10px; font-weight: normal;">Management System</small></td>
            <td class="report-title">
                <strong>LAPORAN PENDAPATAN HARIAN (WIB)</strong><br>
                Periode: {{ $periode }}<br>
                Generated: {{ now()->timezone('Asia/Jakarta')->format('d M Y H:i') }}
            </td>
        </tr>
    </table>

    <div class="kpi-container">
        <div class="kpi-card">
            <div class="kpi-title">Total Pendapatan</div>
            <div class="kpi-value">Rp {{ number_format($data['total_order_revenue'], 0, ',', '.') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Pesanan Sukses</div>
            <div class="kpi-value">{{ $data['order_status_breakdown']['PAID'] ?? 0 }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Timezone</div>
            <div class="kpi-value">Asia/Jakarta (WIB)</div>
        </div>
    </div>

    <div class="section-title">Detail Status Pesanan</div>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah Pesanan</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['order_status_breakdown'] as $status => $count)
            <tr>
                <td><span class="badge {{ $status == 'PAID' ? 'badge-success' : 'badge-pending' }}">{{ $status }}</span></td>
                <td>{{ $count }} Pesanan</td>
                <td>{{ round(($count / array_sum($data['order_status_breakdown'])) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">5 Menu Terlaris (Top Selling)</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Menu</th>
                <th style="text-align: center;">Jumlah Terjual</th>
                <th style="text-align: right;">Kontribusi Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['top_selling_menus'] as $index => $menu)
            <tr class="top-menu-row">
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $menu->menu }}</strong></td>
                <td style="text-align: center;">{{ $menu->qty }}x</td>
                <td style="text-align: right;" class="revenue-text">Terjual Populer</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh sistem Restoran Ngijo Backend.
        <br>Halaman 1 dari 1
    </div>

</body>
</html>