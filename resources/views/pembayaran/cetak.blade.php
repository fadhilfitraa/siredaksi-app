<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi #{{ $pembayaran->id }} - {{ $pembayaran->siswa->nama }}</title>
    <style>
        /* 1. SETUP KERTAS A3 LANDSCAPE */
        @page {
            size: A3 landscape;
            margin: 10mm; /* Margin aman printer */
        }
        
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 98vh; 
        }

        /* 2. CONTAINER UTAMA */
        .kwitansi-container {
            width: 98%;
            height: 95vh;
            border: 4px double #000;
            box-sizing: border-box;
            position: relative;
            display: flex;
        }

        /* 3. BAGIAN KIRI (BONGGOL) */
        .bonggol {
            width: 20%;
            border-right: 3px dashed #000;
            padding: 30px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 16px;
        }

        /* 4. BAGIAN KANAN (KWITANSI UTAMA) */
        .main-receipt {
            width: 80%;
            padding: 40px 50px;
            box-sizing: border-box;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        /* Header Logo */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 4px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-img {
            width: 120px;
            height: auto;
            margin-right: 30px;
        }
        .company-info h2 { 
            margin: 0; 
            color: #0d6efd; 
            font-size: 36px;
            text-transform: uppercase; 
        }
        .company-info p { 
            margin: 5px 0; 
            font-size: 18px;
            color: #333; 
        }

        /* Isi Kwitansi */
        .row { 
            margin-bottom: 25px; 
            display: flex; 
            align-items: baseline;
            font-size: 20px;
        }
        .label { 
            width: 200px;
            font-weight: bold; 
            flex-shrink: 0;
        }
        .content { 
            flex: 1; 
            border-bottom: 2px dotted #000; 
            padding-left: 10px; 
            position: relative;
        }
        .terbilang-box {
            background-color: #f4f4f4;
            padding: 15px;
            font-style: italic;
            font-weight: bold;
            border-radius: 8px;
            margin: 15px 0;
            border: 2px solid #ccc;
            font-size: 22px;
            text-transform: capitalize; /* Biar huruf depan otomatis besar */
        }

        /* Footer */
        .footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 20px;
        }
        .amount-box {
            background: #0d6efd;
            color: white;
            padding: 15px 40px;
            font-size: 32px;
            font-weight: bold;
            border-radius: 10px;
            transform: skewX(-10deg);
            box-shadow: 5px 5px 0px #000;
            border: 2px solid #000;
        }
        .amount-text { transform: skewX(10deg); display: inline-block; }
        
        .signature { text-align: center; width: 300px; font-size: 18px; }
        .signature u { font-weight: bold; display: block; margin-top: 100px; }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 55%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 150px;
            opacity: 0.05;
            pointer-events: none;
            color: #000;
            font-weight: bold;
            z-index: 0;
        }

        .btn-back {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 30px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="kwitansi-container">
        <div class="watermark">LUNAS</div>

        <div class="bonggol">
            <div>
                <strong style="font-size: 24px;">ARSIP</strong><br>
                <small>Simpan lembar ini</small>
                <hr style="border-top: 2px dashed #000;">
                <br>
                <strong>No. Ref:</strong><br>
                #{{ str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT) }}<br><br>
                <strong>Tanggal:</strong><br>
                {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y') }}<br><br>
                <strong>Siswa:</strong><br>
                {{ $pembayaran->siswa->nama }}<br>
                ({{ $pembayaran->siswa->kelas }})<br><br>
                <strong>Nominal:</strong><br>
                Rp {{ number_format($pembayaran->jumlah_bayar) }}
            </div>
            
            <div style="text-align: center;">
                <br><br>
                <small>( Paraf Admin )</small>
            </div>
        </div>

        <div class="main-receipt">
            <div class="header">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="logo-img" onerror="this.style.display='none'">
                <div class="company-info">
                    <h2>BIMBEL AL-KAUTSAR</h2>
                    <p>Jl. Soekarno Hatta (Depan Islamic Center) Rajabasa Bandar Lampung</p>
                    <p>Telp: 0812-3456-7890 | Email: admin@alkautsar.com</p>
                </div>
            </div>

            <div style="text-align: right; font-weight: bold; font-size: 24px; margin-bottom: 30px; color: #555;">
                NO. KWITANSI: #{{ str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT) }}
            </div>

            <div class="row">
                <div class="label">Telah terima dari</div>
                <div class="label" style="width: 20px;">:</div>
                <div class="content" style="text-transform: uppercase;">
                    <strong>{{ $pembayaran->siswa->nama }}</strong> <span style="float: right;">(Kelas: {{ $pembayaran->siswa->kelas }})</span>
                </div>
            </div>

            <div class="row">
                <div class="label">Guna membayar</div>
                <div class="label" style="width: 20px;">:</div>
                <div class="content">
                    Pembayaran SPP / Bimbingan Belajar ({{ $pembayaran->siswa->tingkatan ?? 'Umum' }})
                </div>
            </div>

            <div class="row">
                <div class="label">Terbilang</div>
                <div class="label" style="width: 20px;">:</div>
                <div class="content" style="border:none;">
                   <div class="terbilang-box" id="terbilang-text">Loading...</div>
                </div>
            </div>

            <div class="footer">
                <div class="amount-box">
                    <span class="amount-text">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                </div>
                
                <div class="signature">
                    Bandar Lampung, {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->isoFormat('D MMMM Y') }}<br>
                    Admin Keuangan,
                    <br><br><br>
                    <u>( {{ Auth::user()->name ?? 'Administrator' }} )</u>
                </div>
            </div>
        </div>
    </div>

    <button onclick="window.history.back()" class="btn-back no-print">⬅ Kembali</button>

    <script>
        window.print();

        function terbilang(a){
            var bilangan = ['','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas'];
            var kalimat = "";
            var angka = parseInt(a);

            if(angka < 12){
                kalimat = bilangan[angka];
            } else if(angka < 20){
                kalimat = bilangan[angka-10] + " Belas";
            } else if(angka < 100){
                kalimat = bilangan[Math.floor(angka/10)] + " Puluh " + bilangan[angka%10];
            } else if(angka < 200){
                kalimat = "Seratus " + terbilang(angka-100);
            } else if(angka < 1000){
                kalimat = bilangan[Math.floor(angka/100)] + " Ratus " + terbilang(angka%100);
            } else if(angka < 2000){
                kalimat = "Seribu " + terbilang(angka-1000);
            } else if(angka < 1000000){
                kalimat = terbilang(Math.floor(angka/1000)) + " Ribu " + terbilang(angka%1000);
            } else if(angka < 1000000000){
                kalimat = terbilang(Math.floor(angka/1000000)) + " Juta " + terbilang(angka%1000000);
            }
            return kalimat;
        }

        let nilai = {{ $pembayaran->jumlah_bayar }};
        let hasil = terbilang(nilai) + " Rupiah";
        
        // HAPUS PAGAR DI SINI (Cuma tampilkan hasil text)
        document.getElementById("terbilang-text").innerText = hasil.replace(/\s+/g, ' ').trim();
    </script>

</body>
</html>