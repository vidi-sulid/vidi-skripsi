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
                                    <select wire:model="periode" class="form-control select2" name="periode">
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
                                    <select wire:model="product_asets" class="form-control" name="product_aset_id">
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
                                @forelse($aset as $data)
                                    <?php
                                    $tanggal = date('Y-m-01', strtotime($periode));
                                    $vaAset = App\Library\AsetCalculation::get($data, $periode);
                                    ?>
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
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <span class="text-danger">Data tidak ditemukan !</span>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div @class(['mt-3' => $aset->hasPages()])>
                        {{ $aset->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('addon_js')
    <script>
        var s, i, e = $(".select2"),
            e = (e.length && e.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    dropdownParent: e.parent(),
                    placeholder: e.data("placeholder")
                })
            }), $(".form-repeater"));
        e.length && (s = 2, i = 1, e.on("submit", function(e) {
            e.preventDefault()
        }), e.repeater({
            show: function() {
                var a = $(this).find(".form-control, .form-select"),
                    t = $(this).find(".form-label");
                a.each(function(e) {
                    var r = "form-repeater-" + s + "-" + i;
                    $(a[e]).attr("id", r), $(t[e]).attr("for", r), i++
                }), s++, $(this).slideDown(), $(".select2-container").remove(), $(
                    ".select2.form-select").select2({
                    placeholder: "Placeholder text"
                }), $(".select2-container").css("width", "100%"), $(
                    ".form-repeater:first .form-select").select2({
                    dropdownParent: $(this).parent(),
                    placeholder: "Placeholder text"
                }), $(".position-relative .select2").each(function() {
                    $(this).select2({
                        dropdownParent: $(this).closest(".position-relative")
                    })
                })
            }
        }))
    </script>
@endsection
