<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <header>
        <table>
            <tr>
                <td>
                    <img src="{{ public_path() . '/assets/img/mosque.png' }}" alt="" srcset=""
                        style="width: 100px; height: 100px">
                </td>
                <td class="text-center align-middle">
                    <h2>DEWAN KEMAKMURAN MASJID <br>{{ env('APP_NAME') }}</h2>
                    <p>{{ env('MASJID_ADDRESS') }}</p>
                </td>
            </tr>
        </table>
        <hr style="border: 5px solid black;">
        <hr style="border: 1px solid black" class="mt-n2">
    </header>
    @php
        $tanggal = new DateTime($detail_saldo->tanggal);
    @endphp
    <div class="text-center">
        <h5>LAPORAN AKTIVITAS</h5>
        <h5>PERIODE BULAN {{ $tanggal->format('m Y') }}</h5>
    </div>
    <h5>Pemasukan</h5>
    <table class="table table-bordered mt-4">
        <thead class="text-center table-success">
            <tr>
                <th class="align-middle">Keterangan</th>
                <th class="align-middle">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_pemasukan = 0;
                $total_pengeluaran = 0;
            @endphp
            @foreach ($pemasukan as $item)
                <tr>
                    @php
                        $total_pemasukan += $item->nilai;
                    @endphp
                    <td>{{ $item->keterangan }}</td>
                    <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>Total</b></td>
                <td>Rp. {{ number_format($total_pemasukan, '0', ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <h5>Pengeluaran</h5>
    <table class="table table-bordered mt-4">
        <thead class="text-center table-success">
            <tr>
                <th class="align-middle">Keterangan</th>
                <th class="align-middle">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran as $item)
                <tr>
                    @php
                        $total_pengeluaran += $item->nilai;
                    @endphp
                    <td>{{ $item->keterangan }}</td>
                    <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><b>Total</b></td>
                <td>Rp. {{ number_format($total_pengeluaran, '0', ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <h5>Hasil</h5>
    <table class="table table-bordered mt-4">
        <thead class="text-center table-success">
            <tr>
                <th class="align-middle">Keterangan</th>
                <th class="align-middle">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Kenaikan/Penurunan Aset NETTO</td>
                <td>Rp. {{ number_format($total_pemasukan - $total_pengeluaran, '0', ',', '.') }}</td>
            </tr>
            <tr>
                <td>Saldo awal aset NETTO</td>
                <td>Rp. {{ number_format($detail_saldo->saldo_awal, '0', ',', '.') }}</td>
            </tr>
            <tr>
                <td>
                    Saldo Akhir Aset NETTO
                </td>
                <td>
                    Rp.
                    {{ number_format($total_pemasukan - $total_pengeluaran + $detail_saldo->saldo_awal, '0', ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
