<div>

    <div class="row">
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Mutasi
                </div>
                <div class="card-body">
                    <form id="form1">

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <h6 class="alert-heading mb-1">Error</h6>
                                    <span>{{ $error }}</span>
                                </div>
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="col-log">
                                <div class="form-group mb-0">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis"
                                                id="ckJenisDebet" checked value="D" wire:model="jenis">
                                            <label class="form-check-label" for="ckJenisDebet">Debet</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input " type="radio" name="jenis"
                                                id="ckJenisKredit" value="K" wire:model="jenis">
                                            <label class="form-check-label" for="ckJenisKredit">Kredit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label class="form-label" for="code">Cara Rekening</label>
                                <livewire:search-rekening :rekeningCoa="1" />
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
                                            wire:model="pokokKredit" value="0">
                                        <span class="input-group-text" id="credit">Rp.</span>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="bunga">Bunga</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="credit_interest"
                                            name="credit_interest" aria-describedby="credit_interest"
                                            onblur="rupiah(this)" value="0" wire:model="bungaKredit">
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
                                    <label class="form-label" for="credit">Nominal</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="credit"
                                            name="credit" aria-describedby="credit" value="0"
                                            onblur="rupiah(this)" wire:model="nominalSimpanan">
                                        <span class="input-group-text" id="credit">Rp.</span>
                                    </div>
                                </div>

                            </div>
                        @else
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="credit">Nominal</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control numeral-mask" id="credit"
                                            name="credit" aria-describedby="credit" value="0"
                                            onblur="rupiah(this)" wire:model="nominalSimpanan">
                                        <span class="input-group-text" id="credit">Rp.</span>
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
                        <button type="button" wire:click="simpanTmp" class="btn btn-primary mt-2 ">
                            Ok</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Mutasi</h5>
                </div>
                <div class="card-header">

                </div>
                <div class="card-body" id="detail-mutasi">
                    <div class="table-responsive">
                        <table class="table table-boder table-sm">
                            <thead>
                                <th></th>
                                <th>Rekening</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>


                            </thead>
                            <tbody>
                                @php
                                    $debet = $kredit = 0;
                                @endphp
                                @foreach ($dataTmp as $key => $value)
                                    @php
                                        $debet += $value['debet'];
                                        $kredit += $value['kredit'];
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-center">
                                            <a href="#" wire:click.prevent="removeItem('{{ $key }}')">
                                                <i class="bx bx-x-circle font-2xl text-danger"></i>
                                            </a>
                                        </td>
                                        <td>{{ $value['id'] . '-' . $value['name'] }}</td>
                                        <td>{{ $value['keterangan'] }}</td>
                                        <td align="right">{{ number_format($value['debet']) }}</td>
                                        <td align="right">{{ number_format($value['kredit']) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3">Total</th>
                                    <td align="right">{{ number_format($debet) }}</td>
                                    <td align="right">{{ number_format($kredit) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    @if ($debet == $kredit && $debet > 0)
                        <button type="button" wire:click="saveData" class="btn btn-primary mt-2 "><i
                                class="bx bx-save"></i>
                            Simpan Data Mutasi</button>
                    @endif
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
    </script>
    {{-- @endpush --}}

</div>
