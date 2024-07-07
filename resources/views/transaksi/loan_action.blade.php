<span class="text-nowrap">
    @can('loan_update')
        <button class="btn btn-sm btn-icon me-2" onclick="openModal('{{ route('loan.edit', $data->id) }}')"><i
                class="bx bx-edit"></i></button>
    @endcan
    @can('loan_delete')
        <button class="btn btn-sm btn-icon delete-record" onclick=" hapus('{{ route('loan.destroy', $data->id) }}')"><i
                class="bx bx-trash"></i></button>
    @endcan
</span>
