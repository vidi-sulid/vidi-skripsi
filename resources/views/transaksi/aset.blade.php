@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Transaksi /</span>Aset
    </h4>

    @include('utils.modal')
    <!-- Ajax Sourced Server-side -->
    @can('aset_write')
        <button class="btn btn-primary mb-1 btn-sm " onclick="openModal('{{ route('aset.create') }}')"><i
                class="bx bx-plus"></i>Tambah</button>
    @endcan
    <div class="card">
        <h5 class="card-header">Daftar Aset</h5>
        <div class="card-datatable text-nowrap">

            <div class="table-responsive">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
@endsection
@section('addon_js')
    {!! $dataTable->scripts() !!}
@endsection
