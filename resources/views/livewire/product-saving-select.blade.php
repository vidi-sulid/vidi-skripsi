<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="row g-3">
        <div class="col-sm-6">
            <label class="form-label d-block" for="Code">Kode CIF</label>
            <input type="text" id="Code" name="Code" class="form-control" wire:model="kodeCif" readonly />
        </div>
        <div class="mb-3 col-lg-4">
            <label class="form-label" for="Date">Tanggal</label>
            <input type="date" class="form-control" name="Date" readonly value="{{ getTgl() }}">
        </div>

        <div class="col-sm-6">
            <label class="form-label" for="Religion">Golongan Simpanan Wajib</label>
            <select wire:change="handleSelectChange($event.target.value)" class="select2 form-select"
                name="saving_mandatory">
                <option value="">Pilih Golongan Simpanan Wajib</option>
                @foreach (App\Models\Master\ProductSaving::where('type', 'W')->get() as $data)
                    <option value="{{ $data->code }}">{{ $data->name }}</option>
                @endforeach
            </select>

        </div>
        <div class="col-sm-6">
            <label class="form-label" for="Religion">Golongan Simpanan Pokok</label>
            <select wire:change="handleSelectChangePokok($event.target.value)" class="select2 form-select"
                name="saving_principal">
                <option value="">Pilih Golongan Simpanan Pokok</option>
                @foreach (App\Models\Master\ProductSaving::where('type', 'P')->get() as $data)
                    <option value="{{ $data->code }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label d-block" for="PrincipalAccount">Rekening Pokok</label>
            <input type="text" id="PrincipalAccount" wire:model="rekeningPokok" name="PrincipalAccount"
                class="form-control" readonly />
        </div>
        <div class="col-sm-6">
            <label class="form-label d-block" for="PrincipalAmount">Nominal Mutasi</label>
            <div class="input-group input-group-merge">
                <input type="number" class="form-control numeral-mask" id="PrincipalAmount" name="PrincipalAmount"
                    wire:model="nominalPokok" aria-describedby="PrincipalAmount" readonly>
                <span class="input-group-text" id="PrincipalAmount">Rp.</span>
            </div>
        </div>
        <div class="col-sm-6">
            <label class="form-label d-block" for="MandatoryAccount">Rekening Wajib</label>
            <input type="text" id="MandatoryAccount" wire:model="rekeningWajib" name="MandatoryAccount"
                class="form-control" readonly />
        </div>
        <div class="col-sm-6">
            <label class="form-label d-block" for="MandatoryAmount">Nominal Mutasi</label>
            <div class="input-group input-group-merge">
                <input type="number" class="form-control numeral-mask" id="MandatoryAmounts" name="MandatoryAmount"
                    wire:model="nominalWajib" aria-describedby="MandatoryAmount" readonly>
                <span class="input-group-text" id="MandatoryAmount">Rp.</span>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span> </button>
            <button class="btn btn-success btn-submit btn-next">Simpan</button>
        </div>
    </div>

</div>
