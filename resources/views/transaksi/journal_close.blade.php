<?php
$periode = date('Y-m');
?>
@extends('layouts.app')

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Akuntansi /</span> Penutupan Jurnal
    </h4>

    <div class="row">
        <div class="col-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form
                </div>
                <div class="card-body">
                    <form id="form1">
                        <div class="col">
                            <label for="date_open" class="form-label">Tgl</label>
                            <input type="date" id="date_open" name="date_open" class="form-control" readonly disabled
                                value="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="form-group mb-2">
                            <label>Periode <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="periode">
                                <option value="">Pilih Bulan dan Tahun</option>
                                @for ($year = 2030; $year >= 2015; $year--)
                                    <option value="{{ $year }}"
                                        {{ $year == date('Y', strtotime($year)) ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endfor
                            </select>

                        </div>

                        <button type="button" class="btn btn-primary" id="tombolSave"
                            onclick="save('{{ route('journal-closing.store') }}','post')"><i
                                class="bx bx-save"></i>Posting</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('custom_js')
    <script>
        select2Custom();
    </script>
@endpush
