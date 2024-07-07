@php
    $max_id = \App\Models\Master\ProductAset::max('id');
    $code = str_pad($max_id ? $max_id + 1 : 1, 7, '0', STR_PAD_LEFT);
@endphp
<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Tambah Pembelian Aset</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <label for="code" class="form-label">Kode</label>
                    <input type="text" id="code" name="code" maxlength="8" class="form-control"
                        placeholder="Kode" value="{{ $code }}" readonly disabled />
                </div>
                <div class="col-6">
                    <label for="inventory_number" class="form-label">No Inventaris</label>
                    <input type="text" id="inventory_number" name="inventory_number" class="form-control"
                        placeholder="No Iventaris" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="purchase_date" class="form-label">Tgl Pembelian</label>
                    <input type="date" id="purchase_date" name="purchase_date" class="form-control" readonly disabled
                        value="{{ getTgl() }}" />
                </div>
                <div class="col-6">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="price" class="form-label">Harga Perolehan</label>
                    <input type="text" id="price" name="price" class="form-control numeral-mask"
                        placeholder="Harga Perolehan" value="0" />
                </div>
                <div class="col-6">
                    <label for="depreciation_period" class="form-label">Lama Penyusutan</label>
                    <input type="number" id="depreciation_period" name="depreciation_period" class="form-control"
                        placeholder="Lama Penyusutan" value="0" />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="product_asset_id" class="form-label">Golongan Aset</label>
                    <select id="product_asset_id" name="product_asset_id" class="select2 form-select"
                        data-placeholder="Pilih Golongan Aset">
                        @foreach (App\Models\Master\ProductAset::get() as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->code . '-' . $data->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="residual_value" class="form-label">Residu</label>
                    <input type="text" id="residual_value" name="residual_value" class="form-control numeral-mask"
                        placeholder="Residu" value="0" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary" onclick="save('{{ route('aset.store') }}','post')"><i
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
