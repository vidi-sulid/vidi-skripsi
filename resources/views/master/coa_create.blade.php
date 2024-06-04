<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Tambah COA</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Kode</label>
                    <input type="text" id="code" name="code" maxlength="8" class="form-control numeral-mask"
                        placeholder="Kode" />
                </div>
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama" />
                </div>

            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-check-label">Jenis</label>
                    <div class="col mt-2">
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" value="1"
                                id="induk" />
                            <label class="form-check-label" for="induk">Induk</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="type" class="form-check-input" type="radio" value="0" id="detail"
                                checked="" />
                            <label class="form-check-label" for="detail"> Detail</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary" onclick="save('{{ route('coa.store') }}','post')"><i
                    class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>

<script>
    $('.numeral-mask').toArray().forEach(function(field) {
        var cleave = new Cleave(field, {
            blocks: [1, 3, 3], // Menentukan blok dari setiap bagian angka
            delimiter: '.', // Pemisah ribuan
            numericOnly: true
        });

        $(field).on('input', function() {
            var value = field.value.replace(/\./g, '');

            // Jika panjang value adalah 1, kita hancurkan Cleave dan set nilai secara langsung
            if (value.length === 1) {
                cleave.destroy();
                field.value = value;
            } else if (value.length === 4) {
                cleave.destroy();
                field.value = value.substring(0, value.length - 3) + '.' + value.substring(value
                    .length - 3);
            } else if (value.length > 1) {
                // Jika panjang value lebih dari 1, format ulang menggunakan Cleave
                cleave.setRawValue(value);
            }
        });

    });
</script>
