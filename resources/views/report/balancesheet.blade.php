@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Neraca
    </h4>
    <div class="container-fluid">
        <livewire:report.balancesheet-report />
    </div>
@endsection
