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
    @php
        $no = 1;
        $jumlah = 0;
        $progress = 0;
    @endphp
    <header>
        <table>
            <tr>
                <td>
                    <img src="{{ public_path() . '/assets/img/mosque.png' }}" alt="" srcset=""
                        style="width: 100px; height: 100px">
                </td>
                <td class="text-center">
                    <h2>DEWAN KEMAKMURAN MASJID <br>{{ env('APP_NAME') }}</h2>
                    <p>{{ env('MASJID_ADDRESS') }}</p>
                </td>
            </tr>
        </table>
        <hr style="border: 5px solid black; ">
        <hr style="border: 1px solid black" class="mt-n2">
    </header>
    <table class="table table-bordered mt-4">
        <thead class="text-center bg-warning">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pengajuan</th>
                <th>REALISASI</th>
                <th>Koordinator</th>
                <th>Paraf</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($data as $item)
                <tr>
                    @php
                        $jumlah += $item->jumlah;
                        $progress += $item->progressDistribusi;
                    @endphp
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->progressDistribusi }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td></td>
                </tr>
            @endforeach
            <tr class="font-weight-bold">
                <td colspan="2" class="text-right">
                    Total
                </td>
                <td>
                    {{ $jumlah }}
                </td>
                <td>
                    {{ $progress }}
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
