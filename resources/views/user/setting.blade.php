@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">System /</span> Global Setting
    </h4>

    <div class="card mb-4">
        <form class="card-body" id="form1">
            <h6>1. Info Perusahaan</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" for="company_name">Nama Perusahaan</label>
                    <input type="text" id="company_name" class="form-control" name="company_name"
                        value="{{ $setting->company_name }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="company_address">Alamat</label>
                    <input type="text" id="company_address" class="form-control" name="company_address"
                        value="{{ $setting->company_address }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="company_email">Email</label>
                    <input type="text" id="company_email" class="form-control" name="company_email"
                        value="{{ $setting->company_email }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="company_phone">Telepon</label>
                    <input type="text" id="company_phone" class="form-control phone-mask" name="company_phone"
                        value="{{ $setting->company_phone }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="company_chairman">Ketua</label>
                    <input type="text" id="company_chairman" class="form-control" name="company_chairman"
                        value="{{ $setting->company_chairman }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="company_treasurer">Bendahara</label>
                    <input type="text" id="company_treasurer" class="form-control " name="company_treasurer"
                        value="{{ $setting->company_treasurer }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="company_secretary">Seketaris</label>
                    <input type="text" id="company_secretary" class="form-control" name="company_secretary"
                        value="{{ $setting->company_secretary }}">
                </div>

            </div>
            <div class="pt-4">
                <button type="button" onclick="save('{{ route('setting.update', $setting->id) }}','put')"
                    class="btn btn-primary "><i class="bx bx-save"></i> Simpan</button>
                <button type="reset" class="btn btn-label-secondary" </div>
        </form>
    </div>
@endsection
