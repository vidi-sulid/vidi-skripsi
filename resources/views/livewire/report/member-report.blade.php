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
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Rekening Simpanan Wajib</th>
                                    <th>Rekening Simpanan Pokok</th>
                                    <th>Saldo Simpanan Pokok</th>
                                    <th>Saldo Simpanan Wajib</th>
                                    <td>Username</td>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $pokok = 0;
                                    $wajib = 0;
                                @endphp
                                @forelse($member as $value)
                                    @php
                                        $pokok += $value['principalBalance'];
                                        $wajib += $value['mandatoryBalance'];
                                    @endphp
                                    <tr>
                                        <td> {{ $value['code'] }} </td>
                                        <td> {{ \Carbon\Carbon::parse($value['date'])->format('d M, Y') }} </td>
                                        <td> {{ $value['name'] }} </td>
                                        <td> {{ $value['address'] }} </td>
                                        <td> {{ $value['principalaccount'] }} </td>
                                        <td> {{ $value['mandatoryaccount'] }} </td>
                                        <td> {{ format_currency($value['principalBalance']) }} </td>
                                        <td> {{ format_currency($value['mandatoryBalance']) }} </td>
                                        <td> {{ $value['created_by'] }} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <span class="text-danger">No Sales Data Available!</span>
                                        </td>
                                    </tr>
                                @endforelse
                                @if ($member->isNotEmpty())
                                    <tr>
                                        <td colspan="6" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($pokok) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($wajib) }}</strong></td>
                                        <td></td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div @class(['mt-3' => $member->hasPages()])>
                        {{ $member->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
