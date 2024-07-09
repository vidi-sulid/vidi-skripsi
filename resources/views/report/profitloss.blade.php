@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Laba Rugi
    </h4>
    <div class="container-fluid">
        <livewire:report.profitloss-report />
    </div>
@endsection
