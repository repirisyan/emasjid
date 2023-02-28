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
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Item</th>
                <th colspan="3">Mutasi Keuangan Zakat</th>
                <th colspan="5">Mutasi Keuangan Infaq/Shodaqoh</th>
                <th rowspan="2">PIUTANG</th>
            </tr>
            <tr>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
                <th>Debit Infaq</th>
                <th>Debit Pinjaman</th>
                <th>Kredit Infaq</th>
                <th>Kredit Pinjaman</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $debit = 0;
                $kredit = 0;
                $saldo = 0;
                $debit_infaq = 0;
                $debit_pinjaman = 0;
                $kredit_infaq = 0;
                $kredit_pinjaman = 0;
                $saldo_infaq_shodaqoh = 0;
                $piutang = 0;
            @endphp
            @forelse ($data as $item)
                @php
                    $tanggal = date_create($item->tanggal);
                @endphp
                <tr>
                    <td>{{ $tanggal->format('d M Y') }}</td>
                    <td>{{ $item->item }}</td>
                    <td>Rp. {{ number_format($item->debit, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->kredit, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->saldo, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->debit_infaq, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->debit_pinjaman, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->kredit_infaq, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->kredit_pinjaman, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->saldo_infaq, '0', ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->piutang, '0', ',', '.') }}</td>
                    @php
                        $debit += $item->debit;
                        $kredit += $item->kredit;
                        $saldo += $item->saldo;
                        $debit_infaq += $item->debit_infaq;
                        $debit_pinjaman += $item->debit_pinjaman;
                        $kredit_infaq += $item->kredit_infaq;
                        $kredit_pinjaman += $item->kredit_pinjaman;
                        $saldo_infaq_shodaqoh += $item->saldo_infaq;
                        $piutang += $item->piutang;
                    @endphp
                </tr>
            @empty
                <tr>
                    <td colspan="14"></td>
                </tr>
            @endforelse
            <tr>
                <td></td>
                <td></td>
                <td>Rp. {{ number_format($debit, '0', ',', '.') }}</td>
                <td>Rp. {{ number_format($kredit, '0', ',', '.') }}</td>
                <td></td>
                <td>Rp. {{ number_format($debit_infaq, '0', ',', '.') }}</td>
                <td>Rp. {{ number_format($debit_pinjaman, '0', ',', '.') }}</td>
                <td>Rp. {{ number_format($kredit_infaq, '0', ',', '.') }}</td>
                <td>Rp. {{ number_format($kredit_pinjaman, '0', ',', '.') }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Saldo Akhir</td>
                <td></td>
                <td></td>
                <td>Rp. {{ number_format($debit - $kredit, '0', ',', '.') }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Rp.
                    {{ number_format($debit_infaq + $debit_pinjaman - ($kredit_infaq + $kredit_pinjaman), '0', ',', '.') }}
                </td>
                <td>Rp. {{ number_format($piutang, '0', ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Saldo Total ZIS</td>
                <td>Rp.
                    {{ number_format($debit - $kredit + ($debit_infaq + $debit_pinjaman - ($kredit_infaq + $kredit_pinjaman)), '0', ',', '.') }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
