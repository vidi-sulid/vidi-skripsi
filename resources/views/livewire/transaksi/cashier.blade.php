<div>

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
                                <label class="form-label" for="basic-default-keterangan">Rekening</label>
                                <input type="text" class="form-control" id="name" wire:model="rekening">
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
                        @endif
                        <button type="button" onclick="save('{{ route('cashier.store') }}','post')"
                            class="btn btn-primary "><i class="bx bx-save"></i> Simpan</button>
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

                </div>
            </div>
        </div>
    </div>
</div>
