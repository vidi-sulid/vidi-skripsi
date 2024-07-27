<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Awal <span class="text-danger">*</span></label>
                                    <input wire:model="date_start" type="date" class="form-control" name="date_start"
                                        value="{{ $date_start }}">
                                    @error('date_start')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir <span class="text-danger">*</span></label>
                                    <input wire:model="date_end" type="date" class="form-control" name="date_end"
                                        value="{{ $date_end }}">
                                    @error('date_end')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-1">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bx bx-sort"></i>
                                Filter Report
                            </button>
                            <a class="btn  btn-primary" href="{{ route('profitloss-pdf.index') }}" target="_blank"><i
                                    class="bx bx-file"></i>Cetak</a>

                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class='table-responsive'>
                        <table id="example13" class="table table-bordered small">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                    <th>{{ tanggalIndonesia($date_start) }}</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>{{ tanggalIndonesia($date_end) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $saldoawal = $debit = $credit = $saldo = 0;
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
                                    <td></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
