<div>

    <div class="row">
        <div class="col-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Mutasi
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <h6 class="alert-heading mb-1">Error</h6>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    @endif
                    <form id="form1">
                        <div class="row">
                            <div class="col-lg">
                                <label class="form-label" for="code">Cara Rekening</label>
                                <livewire:search-rekening-coa />
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
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-lg">
                                <label class="form-label" for="description">Keterangan</label>
                                <input type="text" class="form-control" wire:model="keterangan" id="description"
                                    name="description">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-log">
                                <div class="form-group mb-0">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis"
                                                id="pengeluaran" checked value="pengeluaran" wire:model="jenis">
                                            <label class="form-check-label" for="pengeluaran">Pengeluaran</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input " type="radio" name="jenis"
                                                id="pemasukan" value="pemasukan" wire:model="jenis">
                                            <label class="form-check-label" for="pemasukan">Pemasukan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg">
                                <label class="form-label" for="debit">Penarikan</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control numeral-mask" id="debit"
                                        name="debit" aria-describedby="debit" value="0" onblur="rupiah(this)"
                                        wire:model="nominal">
                                    <span class="input-group-text" id="debit">Rp.</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" wire:click="simpanTmp" class="btn btn-primary mt-2 ">
                            Ok</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Mutasi</h5>
                </div>
                <div class="card-header">
                    @if (count($data) > 0)
                        <button type="button" wire:click="saveData" class="btn btn-primary mt-2 "><i
                                class="bx bx-save"></i>
                            Simpan Data Mutasi</button>
                    @endif
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
                                @foreach ($data as $key => $value)
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
