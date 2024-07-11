@php
    $BloodTypes = ['A', 'A+', 'A-', 'AB', 'AB+', 'AB-', 'B', 'B+', 'B-', 'O', 'O+', 'O-'];
    $Religions = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    $MarriageStatuses = ['Kawin', 'Belum Kawin', 'Duda', 'Janda'];
    $Works = getWorks();

@endphp
@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Tambah /</span>Anggota
    </h4>
    <!-- Property Listing Wizard -->
    <div id="wizard-member-listing" class="bs-stepper vertical mt-2">
        <div class="bs-stepper-header">
            <div class="step" data-target="#personal-details">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">
                        <i class='bx bx-user'></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Data personal</span>
                        <span class="bs-stepper-subtitle">Detail KTP</span>
                    </span>
                </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#property-details">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">
                        <i class='bx bx-home'></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Alamat</span>
                        <span class="bs-stepper-subtitle">Detail Tempat Tinggal</span>
                    </span>
                </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#account-details">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">
                        <i class='bx bx-wallet'></i>
                    </span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Rekening</span>
                        <span class="bs-stepper-subtitle">Simpanan Pokok dan Wajib</span>
                    </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <form id="wizard-member-listing-form" onSubmit="return false">
                <!-- Data Personal -->
                <div id="personal-details" class="content">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="Name">Nama</label>
                            <input type="text" id="Name" name="Name" class="form-control" placeholder="Nama" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Gender" id="GenderMale" value="L"
                                    checked>
                                <label class="form-check-label" for="GenderMale">Laki Laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Gender" id="GenderFemale"
                                    value="P">
                                <label class="form-check-label" for="GenderFemale">Perempuan</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="BloodType">Golongan Darah</label>
                            <select id="BloodType" name="BloodType" class="select2 form-select" data-allow-clear="true">
                                <option value="">Pilih Golongan Darah</option>
                                @foreach ($BloodTypes as $BloodType)
                                    <option value="{{ $BloodType }}">Golongan Darah {{ $BloodType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="Religion">Agama</label>
                            <select id="Religion" name="Religion" class="select2 form-select">
                                <option value="">Pilih Agama</option>
                                @foreach ($Religions as $Religion)
                                    <option value="{{ $Religion }}">{{ $Religion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="BornPlace">Tempat Lahir</label>
                            <input type="text" id="BornPlace" name="BornPlace" class="form-control"
                                placeholder="Tempat Lahir" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="BornDate">Tanggal Lahir</label>
                            <input type="text" id="BornDate" name="BornDate" class="form-control flatpickr"
                                placeholder="YYYY-MM-DD" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="MarriageStatus">Status Perkawinan</label>
                            <select id="MarriageStatus" name="MarriageStatus" class="select2 form-select">
                                <option value="">Pilih Status Perkawinan</option>
                                @foreach ($MarriageStatuses as $MarriageStatus)
                                    <option value="{{ $MarriageStatus }}">{{ $MarriageStatus }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="Work">Pekerjaan</label>
                            <select id="Work" name="Work" class="select2 form-select">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach ($Works as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="IdentityCardNumber">Nomor Kartu Tanda Penduduk</label>
                            <input type="text" id="IdentityCardNumber" name="IdentityCardNumber" class="form-control"
                                placeholder="Nomor Kartu Tanda Penduduk" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="FamilyIdentityCardNumber">Nomor Kartu Keluarga</label>
                            <input type="text" id="FamilyIdentityCardNumber" name="FamilyIdentityCardNumber"
                                class="form-control" placeholder="Nomor Kartu Keluarga" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="Contact">Nomor Telepon</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">ID (+62)</span>
                                <input type="text" id="Contact" name="Contact" class="form-control contact-mask"
                                    placeholder="XXX XXXX XXXX" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="Email">Email</label>
                            <input type="email" id="Email" name="Email" class="form-control"
                                placeholder="email@abn.com" />
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button class="btn btn-label-secondary btn-prev" disabled> <i
                                    class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                            </button>
                            <button class="btn btn-primary btn-next"> <span
                                    class="align-middle d-sm-inline-block d-none me-sm-1">Selanjutnya</span> <i
                                    class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Property Details -->
                <div id="property-details" class="content">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl mb-xl-0 mb-2">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="PropertyType">
                                            <span class="custom-option-body">
                                                <i class="bx bx-home"></i>
                                                <span class="custom-option-title">Rumah Sendiri</span>
                                                <small>Rumah Milik Sendiri</small>
                                            </span>
                                            <input name="PropertyType" class="form-check-input" type="radio"
                                                value="0" id="PropertyTypeOwn" checked />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl mb-xl-0 mb-2">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioRent">
                                            <span class="custom-option-body">
                                                <i class="bx bx-wallet"></i>
                                                <span class="custom-option-title">Rumah Sewa</span>
                                                <small>Rumah Kontrak / Kos</small>
                                            </span>
                                            <input name="PropertyType" class="form-check-input" type="radio"
                                                value="1" id="customRadioRent" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label" for="Address">Alamat</label>
                            <textarea id="Address" name="Address" class="form-control" rows="2"
                                placeholder="Alamat Detail Hingga RT / RW"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="Village">Kelurahan</label>
                            <input type="text" id="Village" name="Village" class="form-control"
                                placeholder="Kelurahan / Desa" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="SubDistrict">Kecamatan</label>
                            <input type="text" id="SubDistrict" name="SubDistrict" class="form-control"
                                placeholder="Kecamatan / Kabupaten" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="City">Kota</label>
                            <input type="text" id="City" name="City" class="form-control"
                                placeholder="Kota" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="ZipCode">Kode Pos</label>
                            <input type="number" id="ZipCode" name="ZipCode" class="form-control"
                                placeholder="Kode Pos , Contoh : 34153" />
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span> </button>
                            <button class="btn btn-primary btn-next"> <span
                                    class="align-middle d-sm-inline-block d-none me-sm-1">Selanjutnya</span> <i
                                    class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Price Details -->
                <div id="account-details" class="content">

                    <livewire:product-saving-select />
                </div>
            </form>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
@endsection

@section('addon_js')
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script>
        // document.addEventListener('livewire:init', () => {
        //     Livewire.on('rekeningPokok', (newMessage) => {
        //         console.log(newMessage);
        //     })
        // });


        "use strict";
        ! function() {
            window.Helpers.initCustomOptionCheck();
            var e = document.querySelector(".flatpickr"),
                t = document.querySelector(".contact-mask"),
                i = document.querySelector("#plFurnishingDetails"),
                o = $("#Work"),
                t = (t && new Cleave(t, {
                    delimiter: " ",
                    blocks: [3, 4, 4, 1]
                }), o && (o.wrap('<div class="position-relative"></div>'), o.select2({
                    placeholder: "Pilih Pekerjaan",
                    dropdownParent: o.parent()
                })), e && e.flatpickr(), document.querySelector("#wizard-member-listing"));
            if (null !== t) {
                var o = t.querySelector("#wizard-member-listing-form"),
                    e = o.querySelector("#personal-details"),
                    i = o.querySelector("#property-details"),
                    r = o.querySelector("#account-details"),
                    l = [].slice.call(o.querySelectorAll(".btn-next")),
                    o = [].slice.call(o.querySelectorAll(".btn-prev"));
                const s = new Stepper(t, {
                        linear: !0
                    }),
                    u = FormValidation.formValidation(e, {
                        fields: {
                            Name: {
                                validators: {
                                    notEmpty: {
                                        message: "Mohon Isi Nama"
                                    }
                                }
                            },
                            BornDate: {
                                validators: {
                                    notEmpty: {
                                        message: "Mohon Isi Tgl Lahir"
                                    }
                                }
                            },
                            IdentityCardNumber: {
                                validators: {
                                    notEmpty: {
                                        message: "Mohon Isi KTP"
                                    },
                                    stringLength: {
                                        min: 16,
                                        max: 16,
                                        message: "KTP Harus 16 Digit"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                eleValidClass: "",
                                rowSelector: ".col-sm-6"
                            }),
                            autoFocus: new FormValidation.plugins.AutoFocus,
                            submitButton: new FormValidation.plugins.SubmitButton
                        },
                        init: e => {
                            e.on("plugins.message.placed", function(e) {
                                e.element.parentElement.classList.contains("input-group") && e.element
                                    .parentElement.insertAdjacentElement("afterend", e.messageElement)
                            })
                        }
                    }).on("core.form.valid", function() {
                        s.next()
                    }),
                    c = FormValidation.formValidation(i, {
                        fields: {
                            Address: {
                                validators: {
                                    notEmpty: {
                                        message: "Mohon Isi Alamat Lengkap"
                                    }
                                }
                            },
                            ZipCode: {
                                validators: {
                                    notEmpty: {
                                        message: "Mohon Isi Kode Pos"
                                    },
                                    stringLength: {
                                        min: 4,
                                        max: 5,
                                        message: "Kode Pos Harus Terdiri Dari 4-5 Angka"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                eleValidClass: "",
                                rowSelector: function(e, t) {
                                    return "Address" !== e ? ".col-sm-6" : ".col-lg-12"
                                }
                            }),
                            autoFocus: new FormValidation.plugins.AutoFocus,
                            submitButton: new FormValidation.plugins.SubmitButton
                        }
                    }).on("core.form.valid", function() {
                        s.next()
                    });
                const m = FormValidation.formValidation(r, {
                    fields: {},
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            eleValidClass: "",
                            rowSelector: ".col-md-12"
                        }),
                        autoFocus: new FormValidation.plugins.AutoFocus,
                        submitButton: new FormValidation.plugins.SubmitButton
                    }
                }).on("core.form.valid", function() {
                    // alert("Submitted..!!")
                    var data = $("#wizard-member-listing-form").serialize();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('member.store') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: data,
                        success: function(data) {
                            info("Data Berhasil disimpan !", "bg-success");
                            s.previous();
                            s.previous();
                            $('form')[0].reset();
                            $('#tombolRefresh').click();
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;

                            // Loop through errors and display them
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    var errorMessages = errors[key].join(', ');
                                    info(errorMessages, "bg-warning");
                                }
                            }
                        }
                    });
                });
                l.forEach(e => {
                    e.addEventListener("click", e => {
                        switch (s._currentIndex) {
                            case 0:
                                u.validate();
                                break;
                            case 1:
                                c.validate();
                                break;
                            case 2:
                                m.validate()
                        }
                    })
                }), o.forEach(e => {
                    e.addEventListener("click", e => {
                        switch (s._currentIndex) {
                            case 2:
                            case 1:
                                s.previous()
                        }
                    })
                })
            }
        }();
    </script>
@endsection
