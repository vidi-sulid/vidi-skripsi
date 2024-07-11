<span class="text-nowrap">
    @can('aset_update')
        <button class="btn btn-sm btn-icon me-2" onclick="openModal('{{ route('aset.edit', $data->id) }}')"><i
                class="bx bx-edit"></i></button>
    @endcan
    @can('aset_delete')
        <button class="btn btn-sm btn-icon delete-record" onclick=" hapus('{{ route('aset.destroy', $data->id) }}')"><i
                class="bx bx-trash"></i></button>
    @endcan
</span>
