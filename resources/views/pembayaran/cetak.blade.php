<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran #{{ $pembayaran->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background: #eee; padding: 20px; }
        
        /* Container Struk */
        .struk-box {
            background: #fff;
            width: 210mm; /* A5 Landscape */
            height: 148mm;
            padding: 25px 40px;
            margin: 0 auto;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header { 
            display: flex; 
            align-items: center; 
            border-bottom: 2px dashed #333; 
            padding-bottom: 15px; 
            margin-bottom: 15px;
        }
        .logo-img { width: 70px; height: auto; margin-right: 20px; }
        .company-info h1 { margin: 0; font-size: 22px; color: #333; font-family: Helvetica, sans-serif; font-weight: 800; text-transform: uppercase; }
        .company-info p { margin: 2px 0; font-size: 11px; color: #555; font-family: Helvetica, sans-serif;}

        /* Info Transaksi */
        .meta-info { margin-left: auto; text-align: right; font-size: 12px; }
        .meta-info span { display: block; margin-bottom: 2px; }
        .no-struk { font-weight: bold; font-size: 14px; }

        /* Body Content */
        .client-info { margin-bottom: 15px; font-size: 13px; }
        .client-info span { font-weight: bold; text-transform: uppercase; }

        /* Tabel Rincian */
        .struk-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        
        /* Default Header Kiri */
        .struk-table th { 
            text-align: left; 
            border-bottom: 1px dashed #000; 
            padding: 5px 0; 
            font-size: 12px; 
            text-transform: uppercase; 
        }
        
        .struk-table td { padding: 8px 0; font-size: 13px; vertical-align: top; }
        
        /* --- UPDATE: FIX ALIGNMENT --- */
        /* Memastikan kolom Total Rata Kanan untuk Header (th) maupun Isi (td) */
        .struk-table th.col-total, 
        .struk-table td.col-total { 
            text-align: right !important; /* Paksa Rata Kanan */
            width: 30%; 
            font-weight: bold; 
        }
        
        .col-desc { width: 70%; }

        /* Catatan */
        .note-box {
            background-color: #f9f9f9;
            border: 1px dashed #aaa;
            padding: 8px 10px;
            font-size: 11px;
            margin-bottom: 15px;
            color: #444;
        }
        .note-label { font-weight: bold; text-decoration: underline; margin-bottom: 2px; display: block; }

        /* Total & Terbilang */
        .total-section {
            border-top: 2px dashed #333;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .terbilang-box {
            flex: 1;
            font-size: 11px;
            background: #eee;
            padding: 10px;
            margin-right: 40px;
            border-left: 4px solid #333;
            font-family: Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .terbilang-text {
            display: block;
            margin-top: 8px;
            padding-top: 5px;
            border-top: 1px dotted #999;
            font-weight: bold;
            font-style: italic;
            font-size: 12px;
        }

        .grand-total { text-align: right; }
        .grand-total .label { font-size: 12px; font-weight: bold; display: block; margin-bottom: 5px; }
        .grand-total .amount { 
            font-size: 22px; 
            font-weight: 800; 
            color: #000; 
            display: block; 
            background: #fff;
            padding: 5px 10px;
            border: 2px solid #333;
        }

        /* Footer */
        .footer {
            margin-top: auto; 
            display: flex;
            justify-content: flex-end;
            text-align: center;
            font-family: Helvetica, sans-serif;
        }
        .signature p { margin: 0; font-size: 11px; }
        .signature .name { margin-top: 50px; font-weight: bold; text-decoration: underline; font-size: 12px; }

        /* Print Button */
        .btn-print {
            position: fixed; bottom: 20px; right: 20px;
            background: #333; color: white; padding: 12px 25px;
            border: none; border-radius: 50px; cursor: pointer; font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            font-family: Helvetica, sans-serif;
        }
        .btn-print:hover { background: #000; }

        @media print {
            body { background: white; padding: 0; margin: 0; }
            .struk-box { border: none; box-shadow: none; width: 100%; height: auto; margin: 0; }
            .btn-print { display: none; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="struk-box">
        
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img">
            <div class="company-info">
                <h1>BIMBEL AL-KAUTSAR</h1>
                <p>Jl. Soekarno Hatta (Depan Islamic Center)</p>
                <p>Bandar Lampung | Telp: 0721-788410</p>
            </div>
            <div class="meta-info">
                <span class="no-struk">NO: #{{ $pembayaran->id }}/{{ date('m/y', strtotime($pembayaran->tanggal_bayar)) }}</span>
                <span>Tgl: {{ date('d/m/Y', strtotime($pembayaran->tanggal_bayar)) }}</span>
                <span>Metode: {{ strtoupper($pembayaran->metode_pembayaran) }}</span>
            </div>
        </div>

        <div class="client-info">
            Diterima Dari: <br>
            <span>{{ $pembayaran->siswa->nama ?? 'Siswa Dihapus' }}</span> ({{ $pembayaran->siswa->kelas ?? '-' }} - {{ $pembayaran->siswa->asal_sekolah ?? '' }})
        </div>

        <table class="struk-table">
            <thead>
                <tr>
                    <th class="col-desc">KETERANGAN PEMBAYARAN</th>
                    <th class="col-total">JUMLAH (IDR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-desc">
                        Pembayaran Uang Bimbel Periode <strong>{{ $pembayaran->bulan_bayar }}</strong>
                    </td>
                    <td class="col-total">
                        {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        @if($pembayaran->keterangan)
        <div class="note-box">
            <span class="note-label">KETERANGAN:</span>
            {{ $pembayaran->keterangan }}
        </div>
        @else
        <div class="note-box">
            <span class="note-label">CATATAN:</span> -
        </div>
        @endif

        <div class="total-section">
            <div class="terbilang-box">
                <span>Terbilang:</span>
                <span class="terbilang-text">{{ ucwords($terbilang) }} Rupiah</span>
            </div>
            <div class="grand-total">
                <span class="label">TOTAL BAYAR</span>
                <span class="amount">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <div class="signature">
                <p>Bandar Lampung, {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y') }}</p>
                <p>Admin Keuangan,</p>
                <div class="name">({{ strtoupper(Auth::user()->name ?? 'ADMINISTRATOR') }})</div>
            </div>
        </div>

    </div>

    <button class="btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> CETAK STRUK
    </button>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</body>
</html>