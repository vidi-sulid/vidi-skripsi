<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Hapus Transaksi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Faktur</label>
                    <input type="text" id="code" name="code" class="form-control" value="{{ $invoice }}"
                        disabled />
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <label class="form-label">Mutasi</label> <br />

                    @foreach ($data as $key => $value)
                        <div class="form-check form-check-inline mt-3">
                            <input class="form-check-input" type="checkbox" name="mutation[]" id="{{ $key }}"
                                value="{{ $value }}" checked />
                            <label class="form-check-label" for="{{ $key }}">{{ $key }}</label>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary" onclick="deleteJurnal()"><i class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>
<script>
    function deleteJurnal() {
        Swal.fire({
            title: "Apakah Anda Yakin ?",
            text: "Data Yang Sudah Dihapus Tidak Bisa Dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Tetap Hapus!"
        }).then((result) => {
            if (result.value) {
                var ajaxPost = save('{{ route('journal.update', $invoice) }}', 'put');
                window.location.href = "{{ route('journal-report.index') }}";
                console.log(ajaxPost);
            }
        })
    }
</script>
