<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input wire:model="date" type="date" class="form-control" name="date"
                                        value="{{ $date }}">
                                    @error('date')
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
                            <a class="btn  btn-primary" href="{{ route('loan-pdf.index') }}"><i
                                    class="bx bx-file"></i>Cetak</a>
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
                    <div class='table-responsives'>
                        <table class="table table-bordered table-striped mb-0" style="font-size: 12px;"
                            id="exampleReport">
                            <div wire:loading.flex
                                class="col-12 position-absolute justify-content-center align-items-center"
                                style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th>Rekening</th>
                                    <th>Tanggal </th>
                                    <th>JthTmpo</th>
                                    <th>Nama</th>
                                    <th class="text-nowrap">Total Pinjaman</th>
                                    <th>Lama</th>
                                    <th>SB</th>
                                    <th class="text-nowrap">Tunggakan Pokok</th>
                                    <th class="text-nowrap">Tunggakan Bunga</th>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $tunggakanPokok = 0;
                                    $tunggakanBunga = 0;
                                    $totalPinjaman = 0;
                                @endphp
                                @forelse($loan as $value)
                                    @php
                                        $tunggakanPokok += $value['tunggakanPokok'];
                                        $tunggakanBunga += $value['tunggakanBunga'];
                                        $totalPinjaman += $value['loan_amount'];
                                    @endphp
                                    <tr>
                                        <td> {{ $value['rekening'] }} </td>
                                        <td class="text-nowrap"> {{ tanggalIndonesia($value['date_open']) }}
                                        </td>
                                        <td class="text-nowrap"> {{ tanggalIndonesia($value['jthtmp']) }} </td>
                                        <td> {{ $value['member']['name'] }} </td>
                                        <td align="right"> {{ format_currency($value['loan_amount']) }} </td>
                                        <td> {{ $value['loan_term'] }} </td>
                                        <td align="right" class="text-nowrap">
                                            {{ number_format($value['interest_rate'], 2) }} %</td>
                                        <td align="right"> {{ format_currency($value['tunggakanPokok']) }} </td>
                                        <td align="right"> {{ format_currency($value['tunggakanBunga']) }} </td>

                                    @empty
                                    <tr>
                                        <td colspan="8">
                                            <span class="text-danger">Data tidak ditemukan !</span>
                                        </td>
                                    </tr>
                                @endforelse


                            </tbody>
                            <tfoot>
                                @if ($loan->isNotEmpty())
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalPinjaman) }}</strong></td>
                                        <td colspan="2"></td>
                                        <td align="right"><strong>{{ format_currency($totalPinjaman) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalPinjaman) }}</strong></td>

                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                    <div @class(['mt-3' => $loan->hasPages()])>
                        {{ $loan->links() }}
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
