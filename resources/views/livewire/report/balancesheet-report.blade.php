<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input wire:model="start_date" type="date" class="form-control" name="start_date"
                                        value="{{ $date_start }}">
                                    @error('start_date')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <input wire:model="end_date" type="date" class="form-control" name="end_date"
                                        value="{{ $date_end }}">
                                    @error('end_date')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-1">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                Filter Report
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class='table-responsive'>
                        <table class="table table-bordered table-striped text-center mb-0">
                            <div wire:loading.flex
                                class="col-12 position-absolute justify-content-center align-items-center"
                                style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                    <th>{{ \Carbon\Carbon::parse($date_start)->format('d M, Y') }}</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>{{ \Carbon\Carbon::parse($date_end)->format('d M, Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
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


                                    <tr style="height: 20px;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }

                                ?>
                                    <tr @if ($value['type']) {{ 'style=font-weight:1000;' }} @endif>

                                        <td align="left">{{ $key }}</td>
                                        <td align="left"><?php $jumlah = explode('.', $key);
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
