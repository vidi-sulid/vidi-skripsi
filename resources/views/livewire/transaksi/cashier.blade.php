<div id="myDiv">

    <div class="row">
        <div class="col-xl">
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
                                    <input type="text" class="form-control"
                                        value="{{ format_currency($data[0]->loan_amount) }}" readonly disabled>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Sisa Pinjaman</label>
                                    <input type="text" class="form-control"
                                        value="{{ format_currency($data[0]->bakidebet) }}" readonly disabled>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Tunggakan Pokok</label>
                                    <input type="text" class="form-control"
                                        value="{{ format_currency($data[0]->tunggakanPokok) }}" readonly disabled>
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Tunggakan Bunga</label>
                                    <input type="text" class="form-control"
                                        value="{{ format_currency($data[0]->tunggakanBunga) }}" readonly disabled>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="pokok">Pokok</label>
                                    <input type="text" class="form-control numeral-mask" value="0"
                                        id="pokok" name="credit">
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="bunga">Bunga</label>
                                    <input type="text" class="form-control numeral-mask" value="0"
                                        id="bunga" name="credit_interest">
                                </div>
                            </div>
                        @elseif ($type == 'saving')
                            <div class="row ">
                                @if ($data->product->type == 'W')
                                    <div class="col-lg">
                                        <label class="form-label" for="setoran-wajib">Setoran Wajib</label>
                                        <input type="text" class="form-control"
                                            value="{{ format_currency($data->product->mandatory_deposit) }}" readonly
                                            disabled>
                                    </div>
                                @else
                                    <div class="col-lg">
                                        <label class="form-label" for="setoran-wajib">Setoran Pokok</label>
                                        <input type="text" class="form-control"
                                            value="{{ format_currency($data->product->principal_deposit) }}" readonly
                                            disabled>
                                    </div>
                                @endif

                                <div class="col-lg">
                                    <label class="form-label" for="basic-default-keterangan">Saldo</label>
                                    <input type="text" class="form-control"
                                        value="{{ format_currency($data->saldo) }}" readonly disabled>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg">
                                    <label class="form-label" for="credit">Setoran</label>
                                    <input type="text" class="form-control numeral-mask" value="0"
                                        id="credit" name="credit">
                                </div>
                                <div class="col-lg">
                                    <label class="form-label" for="debit">Penarikan</label>
                                    <input type="text" class="form-control numeral-mask" value="0"
                                        id="debit" name="debit">
                                </div>
                            </div>
                        @endif

                        <div class="row ">
                            <div class="col-lg">
                                <label class="form-label" for="description">Keterangan</label>
                                <input type="text" class="form-control" value="{{ $keterangan }}"
                                    id="description" name="description">
                            </div>
                        </div>
                        <button type="button" onclick="save('{{ route('cashier.store') }}','post')"
                            class="btn btn-primary mt-2 "><i class="bx bx-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Mutasi</h5>
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
                                        <td class="text-nowrap">{{ tanggalIndonesia($value->date) }}</td>
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
</div>
