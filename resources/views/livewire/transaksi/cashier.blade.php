<div>

    <div class="row">
        <div class="col-lg-7 col-sm-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Mutasi
                </div>
                <div class="card-body">
                    <form id="form1">
                        <div class="row">
                            <div class="col-lg">
                                <label class="form-label" for="code">Cara Rekening</label>
                                <livewire:search-rekening />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label class="form-label" for="rekening">Rekening</label>
                                <input type="text" class="form-control" id="rekening" name="rekening"
                                    wire:model="rekening">
                            </div>
                            <div class="col-lg">
                                <label class="form-label" for="code">Nama</label>
                                <input type="text" class="form-control" name="name" wire:model="nama" readonly
                                    disabled>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-lg">
                                <label class="form-label" for="basic-default-keterangan">Faktur</label>
                                <input type="text" class="form-control" id="name" readonly disabled
                                    wire:model='invoice'>
                            </div>
                            <div class="col-lg">
                                <label class="form-label" for="code">Tanggal</label>
                                <input type="date" class="form-control" name="date" readonly disabled
                                    value="{{ getTgl() }}">
                                <input type="hidden" name="type" value="{{ $type }}">
                            </div>
                        </div>
                        @if ($type == 'loan')
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Jumlah Pinjaman</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="jumlah_pinjaman"
                                            name="jumlah_pinjaman" aria-describedby="jumlah_pinjaman"
                                            wire:model ="loan_amount" readonly disabled>
                                        <span class="input-group-text" id="jumlah_pinjaman">Rp.</span>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Sisa Pinjaman</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="sisa_pinjaman"
                                            name="sisa_pinjaman" aria-describedby="sisa_pinjaman" wire:model="bakidebet"
                                            readonly disabled>
                                        <span class="input-group-text" id="sisa_pinjaman">Rp.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Tunggakan Pokok</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="tunggakan_pokok"
                                            name="tunggakan_pokok" aria-describedby="tunggakan_pokok"
                                            wire:model="tunggakanPokok" readonly disabled>
                                        <span class="input-group-text" id="tunggakan_pokok">Rp.</span>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Tunggakan Bunga</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="tunggakan_bunga"
                                            name="tunggakan_bunga" aria-describedby="tunggakan_bunga"
                                            wire:model="tunggakanBunga" readonly disabled>
                                        <span class="input-group-text" id="tunggakan_bunga">Rp.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="pokok">Pokok</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="credit"
                                            name="credit" aria-describedby="credit" onblur="rupiah(this)"
                                            value="0">
                                        <span class="input-group-text" id="credit">Rp.</span>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="bunga">Bunga</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="credit_interest"
                                            name="credit_interest" aria-describedby="credit_interest"
                                            onblur="rupiah(this)" value="0">
                                        <span class="input-group-text" id="credit_interest">Rp.</span>
                                    </div>
                                </div>
                            </div>
                        @elseif ($type == 'saving')
                            <div class="row ">
                                @if ($data->product->type == 'W')
                                    <div class="col-lg">
                                        <label class="form-label" for="setoran-wajib">Setoran Wajib</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" class="form-control numeral-mask"
                                                id="setoran_wajib" name="setoran_wajib"
                                                aria-describedby="setoran_wajib" wire:model="setoranWajib" disabled
                                                readonly>
                                            <span class="input-group-text" id="setoran_wajib">Rp.</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg">
                                        <label class="form-label" for="setoran-wajib">Setoran Pokok</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" class="form-control numeral-mask"
                                                id="setoran_pokok" name="setoran_pokok"
                                                aria-describedby="setoran_pokok" wire:model="setoranPokok" disabled
                                                readonly>
                                            <span class="input-group-text" id="setoran_pokok">Rp.</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Saldo</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="saldo"
                                            name="saldo" aria-describedby="saldo" wire:model="saldo" disabled
                                            readonly>
                                        <span class="input-group-text" id="saldo">Rp.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="credit">Setoran</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="credit"
                                            name="credit" aria-describedby="credit" value="0"
                                            onblur="rupiah(this)">
                                        <span class="input-group-text" id="credit">Rp.</span>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="debit">Penarikan</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="debit"
                                            name="debit" aria-describedby="debit" value="0"
                                            onblur="rupiah(this)">
                                        <span class="input-group-text" id="debit">Rp.</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row ">
                            <div class="col-lg">
                                <label class="form-label" for="description">Keterangan</label>
                                <input type="text" class="form-control" wire:model="keterangan" id="description"
                                    name="description">
                            </div>
                        </div>
                        <button type="button" onclick="save('{{ route('cashier.store') }}','post')"
                            class="btn btn-primary mt-2 "><i class="bx bx-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Mutasi</h5>
                    @if (count($mutation) > 0)
                        <a class="btn  btn-primary" href="{{ route('card-pdf.index') }}"><i
                                class="bx bx-file"></i>Cetak</a>
                    @endif
                </div>
                <div class="card-body" id="detail-mutasi">
                    <div class="table-responsive">
                        <table class="table table-boder table-sm">
                            <thead>
                                <th>Tanggal</th>
                                <th>Invoice</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                @if ($type == 'loan')
                                    <th class="text-nowrap">Debet Bunga</th>
                                    <th class="text-nowrap">Kredit Bunga</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach ($mutation as $value)
                                    <tr>
                                        <td alig class="text-nowrap">{{ tanggalIndonesia($value->date) }}</td>
                                        <td class="text-nowrap">{{ $value->invoice }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>{{ format_currency($value->debit) }}</td>
                                        <td>{{ format_currency($value->credit) }}</td>
                                        @if ($type == 'loan')
                                            <td>{{ format_currency($value->debit_interest) }}</td>
                                            <td>{{ format_currency($value->credit_interest) }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('custom_js') --}}
    <script>
        function rupiah(a) {

            var cleave = new Cleave(a, {
                numeral: true,
                numeralDecimalMark: ',',
                delimiter: '.'
            });
            // cleave.setRawValue(a.value);
        }
        document.addEventListener("DOMContentLoaded", () => {
            console.log("okee");
            Livewire.hook('component.initialized', (component) => {
                console.log('component initialized');
            });
            Livewire.hook('element.initialized', (el, component) => {
                console.log('element initialized');
            });
        });
    </script>
    {{-- @endpush --}}

</div>
