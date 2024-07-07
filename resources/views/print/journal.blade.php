<?php
$debit = $credit = $faktur = $n = 0;
?>
@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Jurnal Umum</h3>
    </div>
    <table class="data">
        <tr>
            <th width="30px" align="center">No</th>
            <th width="100px">No Bukti</th>
            <th width="80px">Tanggal</th>
            <th width="80px">Rekening</th>
            <th width="180px">Ket Rekening</th>
            <th>Keterangan</th>
            <th width="100px"> Debet</th>
            <th width="100px"> Kredit</th>
            <th width="80px"> UserName</th>
        </tr>
        @foreach ($data as $value)
            <?php
            $debit += $value->debit;
            $credit += $value->credit;
            $fakturNew = $value->invoice;
            if ($faktur != $value->invoice) {
                $faktur = $value->invoice;
            
                $n++;
                $no = $n;
            } else {
                $fakturNew = '';
                $no = '';
            }
            ?>
            <tr>
                <td align="center">{{ $no }}</td>
                <td align="center">{{ $fakturNew }}</td>
                <td align="center">{{ tanggalIndonesia($value->date) }}</td>
                <td align="center">{{ $value->rekening }}</td>
                <td>{{ $value->coa->name }}</td>
                <td>{{ $value->description }}</td>
                <td align="right">{{ number_format($value->debit) }}</td>
                <td align="right">{{ number_format($value->credit) }}</td>
                <td align="center">{{ $value->username }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="6">Total</th>

            <td align="right">{{ number_format($debit) }}</td>
            <td align="right">{{ number_format($credit) }}</td>
            <th></th>

        </tr>


    </table>
@endsection
