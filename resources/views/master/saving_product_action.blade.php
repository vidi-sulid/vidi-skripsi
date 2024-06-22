<span class="text-nowrap">
    @can('prodouctsaving_update')
        <button class="btn btn-sm btn-icon me-2" onclick="openModal('{{ route('product-saving.edit', $data->id) }}')"><i
                class="bx bx-edit"></i></button>
    @endcan
    @can('prodouctsaving_delete')
        <button class="btn btn-sm btn-icon delete-record"
            onclick=" hapus('{{ route('product-saving.destroy', $data->id) }}')"><i class="bx bx-trash"></i></button>
    @endcan
</span>
