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
                                    <label>Username</label>
                                    <select class="form-control select2" name="product_aset_id">
                                        <option value="">Pilih User</option>
                                        @foreach ($username as $data)
                                            <option value="{{ $data->name }}">{{ $data->name }}</option>
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
                                    <a class="btn  btn-primary" href="{{ route('journal-pdf.index') }}"><i
                                            class="bx bx-file"></i>Cetak</a>
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
                        <table class="table table-bordered table-striped text-center  mb-0" style="font-size: 12px;"
                            id ="exampleReport">
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
                                    <th>Username</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDebit = 0;
                                    $totalCredit = 0;
                                @endphp
                                @foreach ($journal as $data)
                                    @php
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
                                        <td>{{ $data->username }}</td>
                                        <td>
                                            <span class="text-nowrap">
                                                @can('journal_delete')
                                                    <button class="btn btn-sm btn-icon me-2"
                                                        onclick="openModal('{{ route('journal.edit', $data->invoice) }}')"><i
                                                            class="bx bx-edit"></i></button>
                                                @endcan

                                            </span>

                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                @if ($journal->isNotEmpty())
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalDebit) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalCredit) }}</strong></td>
                                        <td colspan="2"></td>
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
            $("#exampleReport").DataTable({
                responsive: true,
                paging: false
            });
        </script>
    @endpush
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
