@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Kartu Mutasi</h3>

        <p>{{ 'Tanggal ' . tanggalIndonesia(getTgl()) }} </p>
    </div>
    <table class="data">
        <tr>
            <th width="100px">Faktur</th>
            <th width="80px">Tanggal</th>
            <th>Keterangan</th>
            <th width="100px">Debit</th>
            <th width="100px">Credit</th>
            <th width="100px">Saldo Akhir</th>
        </tr>
        @php
            $saldoAkhir = 0;
        @endphp
        @foreach ($mutation as $value)
            @php
                $saldoAkhir += $value->credit - $value->debit;
            @endphp
            <tr>
                <td align="center">{{ $value->invoice }}</td>
                <td align="center">{{ tanggalIndonesia($value->date) }}</td>
                <td>{{ $value->description }}</td>
                <td align="right">{{ number_format($value->debit) }}</td>
                <td align="right">{{ number_format($value->credit) }}</td>
                <td align="right">{{ number_format($saldoAkhir) }}</td>
            </tr>
        @endforeach
    </table>
@endsection
