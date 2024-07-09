@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Daftar Anggota</h3>
        <p>{{ tanggalIndonesia(session()->get('judulMember')) }} </p>
    </div>
    <table class="data">
        <tr>
            <th rowspan="2" width="30px" align="center">No</th>
            <th rowspan="2" width="60px">Kode</th>
            <th rowspan="2" width="80px">Tgl Pembukaan</th>
            <th rowspan="2" width="140px">Nama</th>
            <th rowspan="2">Alamat</th>
            <th rowspan="2" width="50px">Jenis Kelamin</th>
            <th colspan="3">Saldo</th>
        </tr>
        <tr>
            <th width="100px"> Simpanan Pokok</th>
            <th width="100px"> Simpanan Wajib</th>
            <th width="100px"> Pinjaman</th>
        </tr>
        @php
            $n = $pokok = $wajib = $pinjaman = 0;
        @endphp
        @foreach ($data as $value)
            @php
                $n++;
                $pokok += $value->principalBalance;
                $wajib += $value->mandatoryBalance;
                $pinjaman += $value->loanBalance;
            @endphp
            <tr>
                <td align="center">{{ $n }}</td>
                <td align="center">{{ $value->code }}</td>
                <td>{{ tanggalIndonesia($value->date) }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->address }}</td>
                <td align="center">{{ $value->gender }}</td>
                <td align="right">{{ number_format($value->mandatoryBalance) }}</td>
                <td align="right">{{ number_format($value->principalBalance) }}</td>
                <td align="right">{{ number_format($value->loanBalance) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="6">Total</th>
            <td align="right">{{ number_format($wajib) }}</td>
            <td align="right">{{ number_format($pokok) }}</td>
            <td align="right">{{ number_format($pinjaman) }}</td>
        </tr>
    </table>
@endsection
