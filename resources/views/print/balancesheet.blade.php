@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Neraca</h3>

        <p>{{ session()->get('judulJournal') }} </p>
    </div>
    <table class="data">
        <tr>
            <th width="80px">Kode</th>
            <th width="200px">Keterangan</th>
            <th width="100px">Saldo Awal</th>
            <th width="100px">Debit</th>
            <th width="100px">Credit</th>
            <th width="100px">Saldo Akhir</th>
        </tr>
        <?php
        $saldoawal = $debit = $credit = $saldo = 0;
        ?>
        @foreach ($data as $key => $value)
            <?php
            if ($key == 3 || $key == 2) {
                $saldoawal += $value['saldoawal'];
                $debit += $value['debit'];
                $credit += $value['credit'];
                $saldo += $value['saldoakhir'];
            }

            if($key == 3 || $key == 2){
                ?>


            <tr>
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            }

            ?>
            <tr <?php if ($value['type']) {
                echo 'style="font-weight:bold"';
            } ?>>
                <td>{{ $key }}</td>
                <td
                    style=" white-space: nowrap; 
                max-width: 200px;       
                overflow: hidden;
                text-overflow: ellipsis;">
                    <?php $jumlah = explode('.', $key);
                    echo str_repeat('&nbsp;', count($jumlah) * count($jumlah)); ?>{{ $value['keterangan'] }}
                </td>
                <td align="right">{{ number_format($value['saldoawal'], 2) }}</td>
                <td align="right">{{ number_format($value['debit'], 2) }}</td>
                <td align="right">{{ number_format($value['credit'], 2) }}</td>
                <td align="right">{{ number_format($value['saldoakhir'], 2) }}</td>

            </tr>
        @endforeach
        <tr style="font-weight:bold">
            <th colspan="2">Total Ekutasi Pasiva</th>
            <td align="right">{{ number_format($saldoawal, 2) }}</td>
            <td align="right">{{ number_format($debit, 2) }}</td>
            <td align="right">{{ number_format($credit, 2) }}</td>
            <td align="right">{{ number_format($saldo, 2) }}</td>
        </tr>
    </table>
@endsection
@section('script')
    <script></script>
@endsection
