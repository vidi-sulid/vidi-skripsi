<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Pembelian Aset</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <label for="code" class="form-label">Kode</label>
                    <input type="text" id="code" name="code" maxlength="8" class="form-control"
                        placeholder="Kode" value="{{ $data->code }}" readonly disabled />
                </div>
                <div class="col-6">
                    <label for="inventory_number" class="form-label">No Inventaris</label>
                    <input type="text" id="inventory_number" name="inventory_number" class="form-control"
                        placeholder="No Iventaris" value="{{ $data->inventory_number }}" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="purchase_date" class="form-label">Tgl Pembelian</label>
                    <input type="date" id="purchase_date" name="purchase_date" class="form-control" readonly disabled
                        value="{{ $data->purchase_date }}" />
                </div>
                <div class="col-6">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama"
                        value="{{ $data->name }}" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="price" class="form-label">Harga Perolehan</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control numeral-mask" id="price" name="price"
                            aria-describedby="price" value="{{ $data->price }}">
                        <span class="input-group-text" id="price">Rp.</span>
                    </div>
                </div>
                <div class="col-6">
                    <label for="depreciation_period" class="form-label">Lama Penyusutan</label>
                    <input type="number" id="depreciation_period" name="depreciation_period" class="form-control"
                        placeholder="Lama Penyusutan" value="{{ $data->depreciation_period }}" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="product_asset_id" class="form-label">Golongan Aset</label>
                    <select id="product_asset_id" name="product_asset_id" class="select2 form-select"
                        data-placeholder="Pilih Golongan Aset">
                        @foreach (App\Models\Master\ProductAset::get() as $value)
                            <option value="{{ $value->id }}"
                                @if ($data->product_asset_id == $value->id) {{ 'selected' }} @endif>
                                {{ $value->code . '-' . $value->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="residual_value" class="form-label">Residu</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control numeral-mask" id="residual_value"
                            name="residual_value" aria-describedby="residual_value" value="{{ $data->residual_value }}">
                        <span class="input-group-text" id="residual_value">Rp.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary"
                onclick="save('{{ route('aset.update', $data->id) }}','put')"><i class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>

<script>
    $('.numeral-mask').toArray().forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralDecimalMark: ',',
            delimiter: '.'
        })
    });


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
