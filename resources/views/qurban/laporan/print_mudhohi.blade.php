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
                    <img src="{{ public_path() . '/assets/img/mosque.webp' }}" style="width: 100px; height: 100px">
                </td>
                <td class="text-center">
                    <h2>DEWAN KEMAKMURAN MASJID <br>{{ env('APP_NAME') }}</h2>
                    <p>{{ env('MASJID_ADDRESS') }}</p>
                </td>
            </tr>
        </table>
        <hr style="border: 5px solid black;">
        <hr style="border: 1px solid black" class="mt-n2">
    </header>
    <table class="table table-bordered mt-4">
        <thead class="text-center table-success">
            <tr>
                <th class="align-middle">{{ $id_master_hewan == 1 ? 'Sapi' : 'Kambing' }} Ke</th>
                <th class="align-middle">Nama</th>
                <th class="align-middle">Alamat</th>
                <th class="align-middle">Kontak</th>
                <th class="align-middle">Permintaan Daging Qurban</th>
                <th class="align-middle">Tanggal Pendaftaran</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->qurban->antrian }}</td>
                    <td>{{ $item->atasNama }}</td>
                    <td>{{ $item->user->alamat }}</td>
                    <td>{{ $item->user->kontak }}</td>
                    <td>{{ $item->permintaan_daging }} Bungkus</td>
                    <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
