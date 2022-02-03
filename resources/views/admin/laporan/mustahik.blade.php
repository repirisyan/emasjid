<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Desa</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->desa }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
