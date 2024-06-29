<span class="text-nowrap">
    @can('prodouctloan_update')
        <button class="btn btn-sm btn-icon me-2" onclick="openModal('{{ route('product-loan.edit', $data->id) }}')"><i
                class="bx bx-edit"></i></button>
    @endcan
    @can('prodouctloan_delete')
        <button class="btn btn-sm btn-icon delete-record"
            onclick=" hapus('{{ route('product-loan.destroy', $data->id) }}')"><i class="bx bx-trash"></i></button>
    @endcan
</span>
