<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Master Simpanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Kode</label>
                    <input type="text" id="code" name="code" maxlength="8" class="form-control"
                        placeholder="Kode" value="{{ $productSaving->code }}" readonly disabled />
                </div>
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" value="{{ $productSaving->name }}"
                        class="form-control" placeholder="Nama" />
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <label for="account_saving" class="form-label">Rekening Simpanan</label>
                    <select id="account_saving" name="account_saving" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($productSaving->account_saving == $rekening->code) {{ 'selected' }} @endif>
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="account_income_administration" class="form-label">Rekening Pendapatan
                        Adminisrtrasi</label>
                    <select id="account_income_administration" name="account_income_administration"
                        class="select2 form-select" data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($productSaving->account_income_administration == $rekening->code) {{ 'selected' }} @endif>
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="account_cost" class="form-label">Rekening Biaya</label>
                    <select id="account_cost" name="account_cost" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($productSaving->account_cost == $rekening->code) {{ 'selected' }} @endif>
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="principal_deposit" class="form-label">Setoran Pokok</label>
                    <input type="text" id="principal_deposit" name="principal_deposit"
                        class="form-control numeral-mask" value="{{ $productSaving->principal_deposit }}" />
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="mandatory_deposit" class="form-label">Setoran Wajib</label>
                    <input type="text" id="mandatory_deposit" name="mandatory_deposit"
                        class="form-control numeral-mask" value="{{ $productSaving->mandatory_deposit }}" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary"
                onclick="save('{{ route('product-saving.update', $productSaving->id) }}','put')"><i
                    class="bx bx-save"></i> Save
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

    var o = document.querySelector(".numeral-mask");

    var s, i, e = $(".select2"),
        e = (e.length && e.each(function() {
            var e = $(this);
            e.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: e.parent(),
                placeholder: e.data("placeholder")
            })
        }), $(".form-repeater"));
    e.length && (s = 2, i = 1, e.on("submit", function(e) {
        e.preventDefault()
    }), e.repeater({
        show: function() {
            var a = $(this).find(".form-control, .form-select"),
                t = $(this).find(".form-label");
            a.each(function(e) {
                var r = "form-repeater-" + s + "-" + i;
                $(a[e]).attr("id", r), $(t[e]).attr("for", r), i++
            }), s++, $(this).slideDown(), $(".select2-container").remove(), $(
                ".select2.form-select").select2({
                placeholder: "Placeholder text"
            }), $(".select2-container").css("width", "100%"), $(
                ".form-repeater:first .form-select").select2({
                dropdownParent: $(this).parent(),
                placeholder: "Placeholder text"
            }), $(".position-relative .select2").each(function() {
                $(this).select2({
                    dropdownParent: $(this).closest(".position-relative")
                })
            })
        }
    }))
</script>
