@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Buku Besar
    </h4>

    <div class="container-fluid">
        <livewire:report.Bookledger :coa="\App\Models\Master\Coa::where('type', 0)->get()" />
    </div>
@endsection
