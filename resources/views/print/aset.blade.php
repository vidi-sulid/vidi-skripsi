@php
    $debit = $credit = $faktur = $n = 0;

    foreach ($data as $value) {
        $key = $value->product->name;
        if (!isset($vaSub[$key])) {
            $vaSub[$key] = ['harga' => 0, 'awal' => 0, 'bulan' => 0, 'akhir' => 0];
        }
        $vaData[$key][$value->id] = $value;
        $vaSub[$key]['harga'] += $value->price;
    }

    $periode = session()->get('periode');
@endphp
@extends('print.print_layout')
@section('content')
    <div class="title-laporan">
        <h3>Laporan Penyusustan Aset</h3>
        <p>{{ tanggalIndonesia($periode, 'M Y') }} </p>
    </div>
    @foreach ($vaData as $key => $value)
        <h4>{{ $key }}</h4>
        <table class="data">
            <tr>
                <th width="50px">Kode</th>
                <th width="80px">Tgl Pembelian</th>
                <th>No Inventaris</th>
                <th>Nama</th>
                <th width="110px">Harga</th>
                <th width="80px">Lama Penyusustan</th>
                <th width="30px">Ke</th>
                <th width="110px">Saldo Awal</th>
                <th width="110px">Penyusutan</th>
                <th width="110px">Saldo Akhir</th>
            </tr>
            @foreach ($value as $key1 => $value1)
                @php
                    $tanggal = date('Y-m-01', strtotime($periode));
                    $vaAset = App\Library\AsetCalculation::get($value1, $periode);
                    $vaSub[$key]['awal'] += $vaAset['penyusutanAwal'];
                    $vaSub[$key]['bulan'] += $vaAset['penyusutan'];
                    $vaSub[$key]['akhir'] += $vaAset['penyusutanAkhir'];
                @endphp
                <tr>
                    <td align="center">{{ $value1->code }}</td>
                    <td align="center">{{ tanggalIndonesia($value1->purchase_date) }}</td>

                    <td>{{ $value1->inventory_number }}</td>
                    <td>{{ $value1->name }}</td>
                    <td align="right">{{ number_format($value1->price) }}</td>
                    <td align="center">{{ $value1->depreciation_period }}</td>


                    <td align="center">{{ $vaAset['ke'] }}</td>
                    <td align="right">{{ number_format($vaAset['penyusutanAwal']) }}</td>
                    <td align="right">{{ number_format($vaAset['penyusutan']) }}</td>
                    <td align="right">{{ number_format($vaAset['penyusutanAkhir']) }}</td>

                </tr>
            @endforeach
            <tr>
                <th colspan="4">Sub Total</th>

                <td align="right">{{ number_format($vaSub[$key]['harga']) }}</td>
                <th colspan="2"></th>
                <td align="right">{{ number_format($vaSub[$key]['awal']) }}</td>
                <td align="right">{{ number_format($vaSub[$key]['bulan']) }}</td>
                <td align="right">{{ number_format($vaSub[$key]['akhir']) }}</td>


            </tr>
        </table>
    @endforeach
@endsection
