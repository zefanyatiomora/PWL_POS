<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 1.5;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td, th {
            padding: 8px 5px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Dark green background for headers */
            color: white; /* White text for headers */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        tr:nth-child(odd) {
            background-color: #ffffff; /* White for odd rows */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .company-info {
            font-size: 12pt;
        }

        .report-title {
            font-size: 18pt;
            margin: 20px 0;
            text-align: center;
        }

        ul {
            padding-left: 20px;
            margin: 0;
            list-style-type: none; /* Remove bullet points */
        }

        .footer {
            margin-top: 20px;
            font-size: 10pt;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('images/polinema-logo.png') }}" width="150" height="110" class="logo">
            </td>
            
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                </span>
                <span class="text-center d-block font-13 font-bold mb-1">
                    POLITEKNIK NEGERI MALANG
                </span>
                <span class="text-center d-block font-10">
                    Jl. Soekarno-Hatta No. 9 Malang 65141
                </span>
                <span class="text-center d-block font-10">
                    Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420
                </span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="report-title">LAPORAN DATA PENJUALAN</h3>

    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Penjualan</th>
                <th>Kasir</th>
                <th>Pembeli</th>
                <th>Detail Barang</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $p)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $p->penjualan_kode }}</td>
                <td>{{ $p->user->nama }}</td>
                <td>{{ $p->pembeli }}</td>
                <td>
                    <ul>
                        @foreach($p->penjualan_detail as $detail)
                        <li>{{ $detail->barang->barang_nama }} (Jumlah: {{ $detail->jumlah }}, Harga: {{ number_format($detail->harga, 0, ',', '.') }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ \Carbon\Carbon::parse($p->penjualan_tanggal)->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Data dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>
</body>
</html>
