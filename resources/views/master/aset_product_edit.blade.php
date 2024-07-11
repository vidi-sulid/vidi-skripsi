<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Master Golongan Aset</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="code" class="form-label">Kode</label>
                    <input type="text" id="code" name="code" maxlength="8" class="form-control"
                        placeholder="Kode" value="{{ $data->code }}" readonly disabled />
                </div>
                <div class="col-6 mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama"
                        value="{{ $data->name }}" />
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <label for="account_aset" class="form-label">Rekening Aset</label>
                    <select id="account_aset" name="account_aset" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($data->account_aset == $rekening->code) {{ 'selected' }} @endif>
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="account_depreciation" class="form-label">Rekening Akumulasi</label>
                    <select id="account_depreciation" name="account_depreciation" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($data->account_depreciation == $rekening->code) {{ 'selected' }} @endif>
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="account_income" class="form-label">Rekening Pendapatan</label>
                    <select id="account_income" name="account_income" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($data->account_income == $rekening->code) {{ 'selected' }} @endif>
                                {{ $rekening->code . '-' . $rekening->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="account_cost" class="form-label">Rekening Biaya</label>
                    <select id="account_cost" name="account_cost" class="select2 form-select"
                        data-placeholder="Pilih Rekening">
                        @foreach (App\Models\Master\Coa::where('type', 0)->get() as $rekening)
                            <option value="{{ $rekening->code }}"
                                @if ($data->account_cost == $rekening->code) {{ 'selected' }} @endif>
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
                onclick="save('{{ route('product-aset.update', $data->id) }}','put')"><i class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>

<script>
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
