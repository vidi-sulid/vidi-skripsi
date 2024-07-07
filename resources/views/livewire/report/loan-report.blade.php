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
                        <table class="table table-bordered table-striped mb-0" style="font-size: 12px;">
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
                                    <th>Total Pinjaman</th>
                                    <th>Jangka Waktu</th>
                                    <th>Suku Bunga</th>
                                    <th>Tunggakan Pokok</th>
                                    <th>Tunggakan Bunga</th>
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
                                        <td style="white-space: normal;"> {{ tanggalIndonesia($value['date_open']) }}
                                        </td>
                                        <td> {{ tanggalIndonesia($value['jthtmp']) }} </td>
                                        <td> {{ $value['member']['name'] }} </td>
                                        <td> {{ format_currency($value['loan_amount']) }} </td>
                                        <td> {{ $value['loan_term'] }} </td>
                                        <td> {{ number_format($value['interest_rate'], 2) }} %</td>
                                        <td> {{ format_currency($value['tunggakanPokok']) }} </td>
                                        <td> {{ format_currency($value['tunggakanBunga']) }} </td>

                                    @empty
                                    <tr>
                                        <td colspan="8">
                                            <span class="text-danger">No Sales Data Available!</span>
                                        </td>
                                    </tr>
                                @endforelse
                                @if ($loan->isNotEmpty())
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalPinjaman) }}</strong></td>
                                        <td colspan="2"></td>
                                        <td align="right"><strong>{{ format_currency($totalPinjaman) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($totalPinjaman) }}</strong></td>

                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div @class(['mt-3' => $loan->hasPages()])>
                        {{ $loan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
