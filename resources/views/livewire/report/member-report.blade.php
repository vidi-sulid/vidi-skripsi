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
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select wire:model="gender" class="form-control select2" name="product_aset_id">
                                        <option value="">Semua</option>
                                        <option value="L">Laki laki</option>
                                        <option value="P">Perempuan</option>

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
                            <a class="btn  btn-primary" href="{{ route('member-pdf.index') }}" target="_blank"><i
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
                    <div class='table-responssive'>
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
                                    <th>Action </th>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th class="text-nowrap">Saldo Simpanan Pokok</th>
                                    <th class="text-nowrap">Saldo Simpanan Wajib</th>
                                    <th class="text-nowrap">Saldo Pinjaman</th>
                                    <td>Username</td>
                                </tr>

                            </thead>
                            <tbody>
                                @php
                                    $pokok = 0;
                                    $wajib = 0;
                                    $pinjaman = 0;
                                @endphp
                                @forelse($member as $value)
                                    @php
                                        $pokok += $value['principalBalance'];
                                        $wajib += $value['mandatoryBalance'];
                                        $pinjaman += $value['loanBalance'];
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="text-nowrap">
                                                @can('productaset_update')
                                                    <a class="btn btn-sm btn-icon me-2"
                                                        href="{{ route('member.edit', $value['id']) }}"><i
                                                            class="bx bx-edit"></i></a>
                                                @endcan
                                                @can('productaset_delete')
                                                    <button class="btn btn-sm btn-icon delete-record"
                                                        onclick=" hapus('{{ route('member.destroy', $value['id']) }}')"><i
                                                            class="bx bx-trash"></i></button>
                                                @endcan
                                            </span>

                                        </td>
                                        <td> {{ $value['code'] }} </td>
                                        <td class="text-nowrap">
                                            {{ tanggalIndonesia($value['date']) }} </td>
                                        <td align="left"> {{ $value['name'] }} </td>
                                        <td align="left" class="text-nowrap"> {{ $value['address'] }} </td>
                                        <td align="right"> {{ format_currency($value['principalBalance']) }} </td>
                                        <td align="right"> {{ format_currency($value['mandatoryBalance']) }} </td>
                                        <td align="right"> {{ format_currency($value['loanBalance']) }} </td>
                                        <td> {{ $value['username'] }} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <span class="text-danger">Data tidak ditemukan !</span>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                            <tfoot>
                                @if ($member->isNotEmpty())
                                    <tr>
                                        <td colspan="5" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong>{{ format_currency($pokok) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($wajib) }}</strong></td>
                                        <td align="right"><strong>{{ format_currency($pinjaman) }}</strong></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                    <div @class(['mt-3' => $member->hasPages()])>
                        {{ $member->links() }}
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
                }, 1000);

            });
        </script>
    @endpush
</div>
