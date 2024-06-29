@php
    $max_id = \App\Models\Master\ProductAset::max('id');
    $code = 'PJ_' . str_pad($max_id ? $max_id + 1 : 1, 2, '0', STR_PAD_LEFT);
@endphp
<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Tambah Master Pinjaman</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Kode</label>
                    <input type="text" id="code" name="code" maxlength="8" class="form-control"
                        placeholder="Kode" value="{{ $code }}" readonly disabled />
                </div>
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama" />
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <label for="account_loan" class="form-label">Rekening Pinjaman</label>
                    <select id="account_loan" name="account_loan" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}">
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
                            <option value="{{ $rekening->code }}">
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="account_income_interest" class="form-label">Rekening Pendapatan Bunga</label>
                    <select id="account_income_interest" name="account_income_interest" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}">
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="account_dutystamp" class="form-label">Rekening Materai</label>
                    <select id="account_dutystamp" name="account_dutystamp" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}">
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary"
                onclick="save('{{ route('product-loan.store') }}','post')"><i class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>

<script>
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
