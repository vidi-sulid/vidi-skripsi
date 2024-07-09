@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Laba Rugi</h3>

        <p>{{ session()->get('judulProfitLoss') }} </p>
    </div>
    <table class="data">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Keterangan</th>
                <th>Saldo Awal</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $saldoawal = $debit = $credit = $saldo = 0;
            $data = $data['data'];
            ?>

            @foreach ($data['labaOP'] as $key => $value)
                <?php
                // Calculate values based on conditions
                if (!$value['type']) {
                    if (substr($key, 0, 1) == '4') {
                        $saldoawal += $value['saldoawal'];
                        $debit += $value['credit'] - $value['debit'];
                        $saldo += $value['saldoakhir'];
                    } else {
                        $credit += $value['debit'] - $value['credit'];
                        $saldoawal -= $value['saldoawal'];
                        $saldo -= $value['saldoakhir'];
                    }
                }
                ?>

                <!-- Display data in the table -->
                <tr @if ($value['type']) {{ 'style=font-weight:1000;' }} @endif>
                    <td>{{ $key }}</td>
                    <td><?php $jumlah = explode('.', $key);
                    echo str_repeat('&nbsp;', count($jumlah) * count($jumlah)); ?>{{ $value['keterangan'] }}
                    </td>
                    <td align="right">{{ number_format($value['saldoawal'], 2) }}</td>
                    <td align="right">{{ number_format($value['debit'], 2) }}</td>
                    <td align="right">{{ number_format($value['credit'], 2) }}</td>
                    <td align="right">{{ number_format($value['saldoakhir'], 2) }}</td>
                </tr>
            @endforeach

            <!-- Display totals for Laba Rugi Operasional -->
            <tr style="font-weight:bold">
                <th colspan="2">Laba Rugi Operasional</th>
                <td align="right">{{ number_format($saldoawal, 2) }}</td>
                <td align="right">{{ number_format($debit, 2) }}</td>
                <td align="right">{{ number_format($credit, 2) }}</td>
                <td align="right">{{ number_format($saldo, 2) }}</td>
            </tr>

            <!-- Add a blank row -->
            <tr style="height: 20px;">
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <?php
            // Reset variables for Laba Rugi Non Operasional
            $saldoawal = $debit = $credit = $saldo = 0;
            ?>

            @foreach ($data['labaNonOP'] as $key => $value)
                <?php
                // Calculate values based on conditions
                if (!$value['type']) {
                    if (substr($key, 0, 1) == '4') {
                        $saldoawal += $value['saldoawal'];
                        $debit += $value['credit'] - $value['debit'];
                        $saldo += $value['saldoakhir'];
                    } else {
                        $credit += $value['debit'] - $value['credit'];
                        $saldoawal -= $value['saldoawal'];
                        $saldo -= $value['saldoakhir'];
                    }
                }
                ?>

                <!-- Display data in the table -->
                <tr @if ($value['type']) {{ 'style=font-weight:1000;' }} @endif>
                    <td>{{ $key }}</td>
                    <td><?php $jumlah = explode('.', $key);
                    echo str_repeat('&nbsp;', count($jumlah) * count($jumlah)); ?>{{ $value['keterangan'] }}
                    </td>
                    <td align="right">{{ number_format($value['saldoawal'], 2) }}</td>
                    <td align="right">{{ number_format($value['debit'], 2) }}</td>
                    <td align="right">{{ number_format($value['credit'], 2) }}</td>
                    <td align="right">{{ number_format($value['saldoakhir'], 2) }}</td>
                </tr>
            @endforeach

            <!-- Display totals for Laba Rugi Non Operasional -->
            <tr style="font-weight:bold">
                <th colspan="2">Laba Rugi Non Operasional</th>
                <td align="right">{{ number_format($saldoawal, 2) }}</td>
                <td align="right">{{ number_format($debit, 2) }}</td>
                <td align="right">{{ number_format($credit, 2) }}</td>
                <td align="right">{{ number_format($saldo, 2) }}</td>
            </tr>
        </tbody>
    </table>
@endsection
@section('script')
    <script></script>
@endsection
