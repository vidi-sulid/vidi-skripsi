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
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Rekening</label>

                                    <select id="yourSelect2Element" class="form-control select2" wire:model="rekening"
                                        name="rekening">
                                        <option value="">Pilih Rekening</option>
                                        @foreach ($coa as $data)
                                            <option value="{{ $data->code }}">
                                                {{ $data->code . '-' . $data->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-0 mt-1">
                                    <button type="submit" class="btn btn-primary">
                                        <span wire:target="generateReport" wire:loading
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <i wire:target="generateReport" wire:loading.remove class="bx bx-sort"></i>
                                        Filter Report
                                    </button>
                                    <a class="btn  btn-primary" href="{{ route('bookledger-pdf.index') }}"
                                        target="_blank"><i class="bx bx-file"></i>Cetak</a>
                                </div>
                            </div>

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
                    <div class='table-respon3sive'>

                        @php
                            $idTable = uniqid();
                        @endphp
                        <table class="table table-bordered table-striped text-center  mb-0" style="font-size: 12px;"
                            id="tableReport">
                            <div wire:loading.flex
                                class="col-12 position-absolute justify-content-center align-items-center"
                                style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Faktur</th>
                                    <th>Rekening</th>
                                    <th>Keterangan</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                    <th>Username</th>

                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td align="left">Saldo Awal</td>
                                    <td></td>
                                    <td></td>

                                    <td align="right">{{ format_currency($saldo) }}</td>
                                    <td></td>
                                </tr>
                                @php
                                    $totalDebit = 0;
                                    $totalCredit = 0;
                                @endphp
                                @foreach ($journal as $data)
                                    @php
                                        if (
                                            substr($data->rekening, 0, 1) == '1' ||
                                            substr($data->rekening, 0, 1) == '5'
                                        ) {
                                            $saldo += $data->debit - $data->credit;
                                        } else {
                                            $saldo += $data->credit - $data->debit;
                                        }
                                        $totalDebit += $data->debit;
                                        $totalCredit += $data->credit;
                                    @endphp
                                    <tr>

                                        <td class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($data->date)->format('d M, Y') }}</td>

                                        <td class="text-nowrap">{{ $data->invoice }}</td>
                                        <td align="left" class="text-nowrap">
                                            {{ $data->rekening . ' ' . $data->coa->name }}</td>
                                        <td align="left">{{ $data->description }}</td>

                                        <td align="right">{{ format_currency($data->debit) }}</td>
                                        <td align="right">{{ format_currency($data->credit) }}</td>
                                        <td align="right">{{ format_currency($saldo) }}</td>
                                        <td>{{ $data->username }}</td>


                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                @if ($journal->isNotEmpty())
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalDebit) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalCredit) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($saldo) }}</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tfoot>

                        </table>
                    </div>
                    <div @class(['mt-3' => $journal->hasPages()])>
                        {{ $journal->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('custom_js')
        <script>
            initializeDataTable();
            Livewire.hook('component.init', ({
                component,
                cleanup
            }) => {
                initializeDataTable();
                select2Custom();
            });
            Livewire.on('refresh', () => {
                setTimeout(() => {
                    initializeDataTable();

                    select2Custom();
                    $('#yourSelect2Element').on('change', function(e) {
                        var data = $(this).val();
                        @this.set('rekening', data);
                    });
                }, 1000);

            });
            $('#yourSelect2Element').on('change', function(e) {
                var data = $(this).val();
                @this.set('rekening', data);
            });
        </script>
    @endpush

</div>
