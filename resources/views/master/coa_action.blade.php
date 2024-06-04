<span class="text-nowrap">
    @can('coa_update')
        <button class="btn btn-sm btn-icon me-2" onclick="openModal('{{ route('coa.edit', $data->id) }}')"><i
                class="bx bx-edit"></i></button>
    @endcan
    @can('coa_delete')
        <button class="btn btn-sm btn-icon delete-record" onclick=" hapus('{{ route('coa.destroy', $data->id) }}')"><i
                class="bx bx-trash"></i></button>
    @endcan
</span>
