@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Kartu Mutasi</h3>

        <p>{{ 'Tanggal ' . tanggalIndonesia(getTgl()) }} </p>
    </div>
    <table class="data">
        <tr>
            <th rowspan="2" width="100px">Faktur</th>
            <th rowspan="2" width="80px">Tanggal</th>
            <th rowspan="2">Keterangan</th>
            <th colspan="3">Pokok</th>
            <th colspan="3">Bunga</th>
            <th rowspan="2" width="100px">Total Pembayaran</th>
        </tr>
        <tr>
            <th width="100px">Debet</th>
            <th width="100px">Kredit</th>
            <th width="100px">Sisa</th>
            <th width="100px">Debet</th>
            <th width="100px">Kredit</th>
            <th width="100px">Sisa</th>
        </tr>
        @php
            $saldoAkhir = 0;
            $saldoAkhirBunga = 0;
            $totalPembayaran = 0;
        @endphp

        @foreach ($mutation as $value)
            @php
                $saldoAkhir += $value->debit - $value->credit;
                $saldoAkhirBunga += $value->debit_interest - $value->credit_interest;
                $totalPembayaran = $value->credit + $value->credit_interest;
            @endphp
            <tr>
                <td align="center">{{ $value->invoice }}</td>
                <td align="center">{{ tanggalIndonesia($value->date) }}</td>
                <td>{{ $value->description }}</td>
                <td align="right">{{ number_format($value->debit) }}</td>
                <td align="right">{{ number_format($value->credit) }}</td>
                <td align="right">{{ number_format($saldoAkhir) }}</td>
                <td align="right">{{ number_format($value->debit_interest) }}</td>
                <td align="right">{{ number_format($value->credit_interest) }}</td>
                <td align="right">{{ number_format($saldoAkhirBunga) }}</td>
                <td align="right">{{ number_format($totalPembayaran) }}</td>

            </tr>
        @endforeach
    </table>
@endsection
