<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }

        .transaction-table {
            margin-bottom: 10px;
        }

        .transaction-info {
            margin-bottom: 5px;
            font-size: 11pt;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center"><img src="{{ asset('polinema-bw.jpeg') }}"></td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN
                    PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI
                    MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang
                    65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-
                    105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <h3 class="text-center">LAPORAN DATA PENJUALAN</h3>

    @foreach ($penjualan as $p)
        @php
            $totalTransaksi = 0;
        @endphp

        <div class="transaction-info">
            <strong>No: {{ $loop->iteration }}</strong> |
            Tanggal: {{ \Carbon\Carbon::parse($p->penjualan_tanggal)->format('d-m-Y') }} |
            Kasir: {{ $p->user->nama }} |
            Pembeli: {{ $p->pembeli }}
        </div>

        <table class="border-all transaction-table">
            <thead>
                <tr>
                    <th class="text-center" width="10%">No</th>
                    <th width="50%">Barang</th>
                    <th width="10%">Jumlah</th>
                    <th width="30%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($p->penjualan_detail as $detail)
                    @php
                        $subtotal = $detail->jumlah * $detail->harga;
                        $totalTransaksi += $subtotal;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang->barang_nama }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Transaksi</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>

</html>
