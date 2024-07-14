@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Daftar Pinjaman</h3>
        <p>{{ tanggalIndonesia(session()->get('judulLoan')) }} </p>
    </div>
    <table class="data">
        <tr>
            <th rowspan="2" width="30px" align="center">No</th>
            <th rowspan="2" width="60px">Rekening</th>
            <th colspan="2" width="80px">Tgl</th>
            <th rowspan="2" width="140px">Nama</th>
            <th rowspan="2">Alamat</th>
            <th rowspan="2" width="50px">Suku Bunga</th>
            <th rowspan="2" width="100">Total Pinjaman</th>
            <th rowspan="2" width="100">Sisa Pinjaman</th>
            <th colspan="2">Tunggakan</th>
        </tr>
        <tr>
            <th width="60px">Pinjaman</th>
            <th width="60px">Jthtmp</th>
            <th width="100px"> Pokok</th>
            <th width="100px"> Bunga</th>
        </tr>
        @php
            $n = $tunggakanPokok = $tunggakanBunga = $sisaPinjaman = $totalPinjaman = 0;
        @endphp
        @foreach ($data as $value)
            @php
                $n++;
                $tunggakanPokok += $value->tunggakanPokok;
                $tunggakanBunga += $value->tunggakanBunga;
                $totalPinjaman += $value->loan_amount;
                $sisaPinjaman += $value->bakidebet;
            @endphp
            <tr>
                <td align="center">{{ $n }}</td>
                <td align="center">{{ $value->rekening }}</td>
                <td>{{ tanggalIndonesia($value->date) }}</td>
                <td>{{ tanggalIndonesia($value->jthtmp) }}</td>
                <td>{{ $value->member->name }}</td>
                <td>{{ $value->member->address }}</td>
                <td align="right">{{ number_format($value->interest_rate, 2) . '%' }}</td>
                <td align="right">{{ number_format($value->loan_amount) }}</td>
                <td align="right">{{ number_format($value->bakidebet) }}</td>
                <td align="right">{{ number_format($value->tunggakanPokok) }}</td>
                <td align="right">{{ number_format($value->tunggakanBunga) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="7">Total</th>
            <td align="right">{{ number_format($totalPinjaman) }}</td>
            <td align="right">{{ number_format($sisaPinjaman) }}</td>
            <td align="right">{{ number_format($tunggakanPokok) }}</td>
            <td align="right">{{ number_format($tunggakanBunga) }}</td>
        </tr>
    </table>
@endsection
