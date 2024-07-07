<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Master Pinjaman</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <label for="date_open" class="form-label">Tgl Pembelian</label>
                    <input type="date" id="date_open" name="date_open" class="form-control" readonly disabled
                        value="{{ date('Y-m-d') }}" />
                </div>
                <div class="col">
                    <label for="price" class="form-label">Rekening</label>
                    <input type="text" class="form-control" placeholder="Rekening" value="{{ $loan->rekening }}"
                        disabled />
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="loan_amount" class="form-label">Jumlah Pinjaman</label>
                    <input type="text" id="loan_amount" name="loan_amount" class="form-control numeral-mask"
                        wire:change="generateRekening(1)" placeholder="Jumlah Pinjaman"
                        value="{{ $loan->loan_amount }}" />
                </div>
                <div class="col">
                    <label for="provision_fee" class="form-label">Provisi</label>
                    <input type="text" id="provision_fee" name="provision_fee" class="form-control numeral-mask"
                        placeholder="Jumlah Pinjaman" value="{{ $loan->provision_fee }}" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="administration_fee" class="form-label">Administrasi</label>
                    <input type="text" id="administration_fee" name="administration_fee"
                        class="form-control numeral-mask" placeholder="Administrasi"
                        value="{{ $loan->administration_fee }}" />
                </div>
                <div class="col">
                    <label for="stamp_duty" class="form-label">Materai</label>
                    <input type="text" id="stamp_duty" name="stamp_duty" class="form-control numeral-mask"
                        value="{{ $loan->stamp_duty }}" />
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="loan_term" class="form-label">Jangka Waktu</label>
                    <input type="number" id="loan_term" name="loan_term" class="form-control"
                        value="{{ $loan->loan_term }}" />
                </div>
                <div class="col-6">
                    <label for="interest_rate" class="form-label">Suku Bunga</label>
                    <input type="text" id="interest_rate" name="interest_rate" class="form-control sukubunga"
                        value="{{ $loan->interest_rate }}" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary"
                onclick="save('{{ route('loan.update', $loan->id) }}','put')"><i class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>

<script>
    $('.numeral-mask').toArray().forEach(function(field) {
        var cleave = new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: 'Rp ',
            noImmediatePrefix: true,
            rawValueTrimPrefix: true
        });
    });
</script>
