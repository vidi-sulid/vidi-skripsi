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
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Username</label>
                                    <select wire:model="product_asets" class="form-control select2"
                                        name="product_aset_id">
                                        <option value="">Pilih User</option>
                                        @foreach ($username as $data)
                                            <option value="{{ $data->name }}">{{ $data->name }}</option>
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
                        <table class="table table-bordered table-striped text-center  mb-0" style="font-size: 12px;">
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

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDebit = 0;
                                    $totalCredit = 0;
                                @endphp
                                @forelse($journal as $data)
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
                                        <td>{{ $data->description }}</td>

                                        <td align="right">{{ format_currency($data->debit) }}</td>
                                        <td align="right">{{ format_currency($data->credit) }}</td>
                                        <td>{{ $data->username }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <span class="text-danger">No Sales Data Available!</span>
                                        </td>
                                    </tr>
                                @endforelse
                                @if ($journal->isNotEmpty())
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalDebit) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalCredit) }}</strong></td>
                                        <td></td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div @class(['mt-3' => $journal->hasPages()])>
                        {{ $journal->links() }}
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
