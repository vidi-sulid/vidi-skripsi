<div>
    @php
        $max_id = \App\Models\Master\ProductAset::max('id');
        $code = str_pad($max_id ? $max_id + 1 : 1, 7, '0', STR_PAD_LEFT);
    @endphp


    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Tambah Pinjaman</h5>
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
                    <label class="form-label">Golongan Pinjaman</label>
                    <select wire:click="updateGolongan($event.target.value)" class="select2 form-select"
                        name="product_loan_id">
                        <option value="">Pilih Golongan Pinjaman</option>
                        @foreach (App\Models\Master\ProductLoan::get() as $data)
                            <option value="{{ $data->code }}">
                                {{ $data->code . '-' . $data->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">

                <div class="col">
                    <label for="member_code" class="form-label">Anggota</label>
                    <select wire:change="generateRekening($event.target.value)" name="member_code"
                        class="form-select select2">
                        <option value="">Pilih Anggota</option>
                        @foreach ($customer as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->code . '-' . $data->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="price" class="form-label">Rekening</label>
                    <input type="text" class="form-control" placeholder="Rekening" value="{{ $rekening }}"
                        disabled />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="loan_amount" class="form-label">Jumlah Pinjaman</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control numeral-mask" id="loan_amount" name="loan_amount"
                            aria-describedby="loan_amount" value="0" wire:blur="generateRekening">
                        <span class="input-group-text" id="loan_amount">Rp.</span>
                    </div>

                </div>
                <div class="col">
                    <label for="provision_fee" class="form-label">Provisi</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control numeral-mask" id="provision_fee" name="provision_fee"
                            aria-describedby="provision_fee" value="0">
                        <span class="input-group-text" id="provision_fee">Rp.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="administration_fee" class="form-label">Administrasi</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control numeral-mask" id="administration_fee"
                            name="administration_fee" aria-describedby="administration_fee" value="0">
                        <span class="input-group-text" id="administration_fee">Rp.</span>
                    </div>
                </div>
                <div class="col">
                    <label for="stamp_duty" class="form-label">Materai</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control numeral-mask" id="stamp_duty" name="stamp_duty"
                            aria-describedby="stamp_duty" value="0">
                        <span class="input-group-text" id="stamp_duty">Rp.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="loan_term" class="form-label">Jangka Waktu</label>
                    <input type="number" id="loan_term" name="loan_term" class="form-control" value="0" />
                </div>
                <div class="col-6">
                    <label for="interest_rate" class="form-label">Suku Bunga</label>
                    <input type="text" id="interest_rate" name="interest_rate" class="form-control sukubunga"
                        value="0.00" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary" onclick="save('{{ route('loan.store') }}','post')"><i
                    class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>


    <script>
        $('.numeral-mask').toArray().forEach(function(field) {
            new Cleave(field, {
                numeral: true,
                numeralDecimalMark: ',',
                delimiter: '.'
            })
        });


        // var s, i, e = $(".select2"),
        //     e = (e.length && e.each(function() {
        //         var e = $(this);
        //         e.wrap('<div class="position-relative"></div>').select2({
        //             dropdownParent: e.parent(),
        //             placeholder: e.data("placeholder")
        //         })
        //     }), $(".form-repeater"));
        // e.length && (s = 2, i = 1, e.on("submit", function(e) {
        //     e.preventDefault()
        // }), e.repeater({
        //     show: function() {
        //         var a = $(this).find(".form-control, .form-select"),
        //             t = $(this).find(".form-label");
        //         a.each(function(e) {
        //             var r = "form-repeater-" + s + "-" + i;
        //             $(a[e]).attr("id", r), $(t[e]).attr("for", r), i++
        //         }), s++, $(this).slideDown(), $(".select2-container").remove(), $(
        //             ".select2.form-select").select2({
        //             placeholder: "Placeholder text"
        //         }), $(".select2-container").css("width", "100%"), $(
        //             ".form-repeater:first .form-select").select2({
        //             dropdownParent: $(this).parent(),
        //             placeholder: "Placeholder text"
        //         }), $(".position-relative .select2").each(function() {
        //             $(this).select2({
        //                 dropdownParent: $(this).closest(".position-relative")
        //             })
        //         })
        //     }
        // }))
    </script>
</div>
