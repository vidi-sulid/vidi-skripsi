<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Periode <span class="text-danger">*</span></label>
                                    <select wire:model="periode" class="form-control select2" name="periode"
                                        id="yourSelect2Element">
                                        <option value="">Pilih Bulan dan Tahun</option>
                                        @for ($year = 2030; $year >= 2015; $year--)
                                            @for ($month = 1; $month <= 12; $month++)
                                                @php
                                                    $monthYear = date('Y-m', mktime(0, 0, 0, $month, 1, $year));
                                                @endphp
                                                <option value="{{ $monthYear }}"
                                                    {{ $monthYear == date('Y-m', strtotime($periode)) ? 'selected' : '' }}>
                                                    {{ date('F Y', strtotime($monthYear)) }}</option>
                                            @endfor
                                        @endfor
                                    </select>
                                    @error('periode')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Golongan Aset</label>
                                    <select wire:model="product_aset_id" class="form-control select2"
                                        name="product_aset_id" id="yourSelect2Element1">
                                        <option value="">Golongan Aset</option>
                                        @foreach ($productAset as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>

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
                            <a class="btn  btn-primary" href="{{ route('aset-pdf.index') }}"><i
                                    class="bx bx-file"></i>Cetak</a>
                            @if (!$postingStatus)
                                <button type="button" class="btn btn-primary" wire:click="posting">
                                    <i class="bx bx-book"></i>
                                    Posting
                                </button>
                            @endif
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
                    <div class='table-responsivse'>
                        <table class="table table-bordered table-striped text-center mb-0" style="font-size: 12px;"
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
                                    <th>Kode</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>No Inventaris</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Lama Penyusustan</th>
                                    <th>Golongan Aset</th>
                                    <th>Ke</th>
                                    <th>Saldo Awal</th>
                                    <th>Penyusutan</th>
                                    <th>Saldo Akhir</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $harga = $penyusutanAwal = $penyusutan = $penyusutanAkhir = 0;
                                @endphp
                                @foreach ($aset as $data)
                                    @php
                                        $tanggal = date('Y-m-01', strtotime($periode));
                                        $vaAset = App\Library\AsetCalculation::get($data, $periode);
                                        $harga += $data->price;
                                        $penyusutanAwal += $vaAset['penyusutanAwal'];
                                        $penyusutan += $vaAset['penyusutan'];
                                        $penyusutanAkhir += $vaAset['penyusutanAkhir'];
                                    @endphp
                                    <tr>
                                        <td>{{ $data->code }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->purchase_date)->format('d M, Y') }}</td>

                                        <td>{{ $data->inventory_number }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ format_currency($data->price) }}</td>
                                        <td>{{ $data->depreciation_period }}</td>

                                        <td>{{ $data->product->name }}</td>

                                        <td>{{ $vaAset['ke'] }}</td>
                                        <td>{{ format_currency($vaAset['penyusutanAwal']) }}</td>
                                        <td>{{ format_currency($vaAset['penyusutan']) }}</td>
                                        <td>{{ format_currency($vaAset['penyusutanAkhir']) }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                @if ($aset->isNotEmpty())
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($harga) }}</strong></td>
                                        <td colspan="3"></td>
                                        <td align="right"><strong>{{ format_currency($penyusutanAwal) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($penyusutan) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($penyusutanAkhir) }}</strong>
                                        </td>

                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                    <div @class(['mt-3' => $aset->hasPages()])>
                        {{ $aset->links() }}
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
                        @this.set('periode', data);
                    });
                    $('#yourSelect2Element1').on('change', function(e) {
                        var data = $(this).val();
                        console.log(data);
                        @this.set('product_aset_id', data);
                    });
                }, 1000);

            });
        </script>
    @endpush
</div>

@push('custom_js')
    <script>
        $('#yourSelect2Element').on('change', function(e) {
            var data = $(this).val();
            @this.set('periode', data);
        });
        $('#yourSelect2Element1').on('change', function(e) {
            var data = $(this).val();
            console.log(data);
            @this.set('product_aset_id', data);
        });
    </script>
@endpush
