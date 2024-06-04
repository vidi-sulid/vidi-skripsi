<span class="text-nowrap">
    @can('productaset_update')
        <button class="btn btn-sm btn-icon me-2" onclick="openModal('{{ route('product-aset.edit', $data->id) }}')"><i
                class="bx bx-edit"></i></button>
    @endcan
    @can('productaset_delete')
        <button class="btn btn-sm btn-icon delete-record"
            onclick=" hapus('{{ route('product-aset.destroy', $data->id) }}')"><i class="bx bx-trash"></i></button>
    @endcan
</span>
