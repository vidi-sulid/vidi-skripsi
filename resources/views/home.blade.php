@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3 col-lg-3 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-8">
                        <div class="card-body">
                            <h6 class="card-title mb-1 text-nowrap">Selamat Datang {{ auth()->user()->name }} !</h6>
                            <small class="d-block mb-3 text-nowrap">Anda Login Sebagai Admin</small>


                            <a href="{{ route('profile-user.index') }}" class="btn btn-sm btn-primary">Lihat Profile</a>
                        </div>
                    </div>
                    <div class="col-4 pt-3 ps-0">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3  mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="Credit Card"
                                class="rounded">
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                    <span class="d-block">Saldo Kas</span>
                    <h4 class="card-title mb-1">Rp.
                        {{ number_format($cashBalance) }}
                    </h4>
                    <small class="{{ $cashText }} fw-medium"><i
                            class="bx {{ $cashIcon }}"></i>+{{ number_format($cashDaily) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="row">

                <div class="col-lg-6 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body pb-2" style="position: relative;">
                            <span class="d-block fw-medium">Total Aset</span>
                            <h3 class="card-title mb-0">{{ number_format($assetBalance) }}</h3>
                            <div id="assetChart" style="min-height: 95px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body row g-4">
                    <div class="col-md-6 pe-md-4 card-separator">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <h5 class="mb-0">Anggota</h5>
                            <small>Minggu Terakhir</small>
                        </div>
                        <div class="d-flex justify-content-between" style="position: relative;">
                            <div class="mt-auto">
                                <h2 class="mb-2">{{ $members }}
                                </h2>
                                <small class="{{ $memberText }} text-nowrap fw-medium"><i
                                        class="bx {{ $memberIcon }}"></i>
                                    {{ $memberGrowth }} %</small>
                            </div>
                            <div id="membersChart" style="min-height: 120px;"></div>
                            <div class="resize-triggers">
                                <div class="expand-trigger">
                                    <div style="width: 410px; height: 121px;"></div>
                                </div>
                                <div class="contract-trigger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <h5 class="mb-0">Aktivitas</h5>
                            <small>10 Hari Terakhir</small>
                        </div>
                        <div class="d-flex justify-content-between" style="position: relative;">
                            <div class="mt-auto">
                                <h2 class="mb-2">{{ number_format($mutationDeposit) }}</h2>
                                <small class="text-success text-nowrap fw-medium"><i class="bx bx-up-arrow-alt"></i>
                                    {{ number_format($mutationDepositDaily) }}</small>
                            </div>
                            <div id="MutationDepositChart" style="min-height: 120px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Income -->
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Statistik Laba Rugi</h5>
                            <small class="card-subtitle">Ringkasan Tahunan</small>
                        </div>
                        <div class="card-body" style="position: relative;">
                            <div id="totalIncomeChart" style="min-height: 265px;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Laporan</h5>
                                <small class="card-subtitle">Rata Rata Bulanan. Rp.
                                    {{ number_format($averageProfit) }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="totalIncome" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalIncome">
                                    <a class="dropdown-item" href="javascript:void(0);">Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="report-list">
                                <div class="report-list-item rounded-2 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="report-list-icon shadow-sm me-2">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                width="22" height="22" alt="Paypal">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                            <div class="d-flex flex-column">
                                                <span>Pendapatan</span>
                                                <h5 class="mb-0">Rp. {{ number_format($incomeBalance) }}</h5>
                                            </div>
                                            <small class="text-success">+{{ number_format($incomeDaily) }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-list-item rounded-2 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="report-list-icon shadow-sm me-2">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                width="22" height="22" alt="Shopping Bag">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                            <div class="d-flex flex-column">
                                                <span>Biaya</span>
                                                <h5 class="mb-0">Rp. {{ number_format($costBalance) }}</h5>
                                            </div>
                                            <small class="text-danger">+{{ number_format($costDaily) }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-list-item rounded-2">
                                    <div class="d-flex align-items-start">
                                        <div class="report-list-icon shadow-sm me-2">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                width="22" height="22" alt="Wallet">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                            <div class="d-flex flex-column">
                                                <span>Laba Berjalan</span>
                                                <h5 class="mb-0">Rp. {{ number_format($profitBalance) }}</h5>
                                            </div>
                                            <small class="text-success">+{{ number_format($profitDaily) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Income -->
        </div>
        <!--/ Total Income -->
    </div>
@endsection
@section('addon_js')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection
@push('custom_js')
    <script>
        "use strict";
        ! function() {
            let o, e, r, t, s, a, i, n, l;
            l = isDarkStyle ? (o = config.colors_dark.cardColor, e = config.colors_dark.headingColor, r = config.colors_dark
                .textMuted, s = config.colors_dark.borderColor, t = "dark", a = "#4f51c0", i = "#595cd9", n = "#8789ff",
                "#c3c4ff") : (o = config.colors.cardColor, e = config.colors.headingColor, r = config.colors.textMuted,
                s = config.colors.borderColor, t = "", a = "#e1e2ff", i = "#c3c4ff", n = "#a5a7ff", "#696cff");
            var d = document.querySelector("#membersChart"),
                c = {
                    chart: {
                        height: 120,
                        width: 200,
                        parentHeightOffset: 0,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            barHeight: "75%",
                            columnWidth: "60%",
                            startingShape: "rounded",
                            endingShape: "rounded",
                            borderRadius: 9,
                            distributed: !0
                        }
                    },
                    grid: {
                        show: !1,
                        padding: {
                            top: -25,
                            bottom: -12
                        }
                    },
                    colors: [config.colors_label.primary, config.colors_label.primary, config.colors_label.primary, config
                        .colors_label.primary, config.colors_label.primary, config.colors_label.primary, config.colors
                        .primary
                    ],
                    dataLabels: {
                        enabled: !1
                    },
                    series: [{
                        name: 'Anggota',
                        data: {!! $memberDaily !!}
                    }],
                    legend: {
                        show: !1
                    },
                    responsive: [{
                        breakpoint: 1440,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 9,
                                    columnWidth: "60%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1300,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 9,
                                    columnWidth: "60%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1200,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 8,
                                    columnWidth: "50%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1040,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 8,
                                    columnWidth: "50%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 991,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 8,
                                    columnWidth: "50%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 420,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 8,
                                    columnWidth: "50%"
                                }
                            }
                        }
                    }],
                    xaxis: {
                        categories: {!! $daily !!},
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                colors: r,
                                fontSize: "13px"
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: !1
                        }
                    }
                },
                d = (null !== d && new ApexCharts(d, c).render(), document.querySelector("#MutationDepositChart")),
                c = {
                    chart: {
                        height: 120,
                        width: 340,
                        parentHeightOffset: 0,
                        toolbar: {
                            show: !1
                        },
                        type: "area"
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        width: 2,
                        curve: "smooth"
                    },
                    series: [{
                        name: "Mutasi Simpanan",
                        data: {!! $mutationDaily !!}
                    }],
                    colors: [config.colors.success],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: t,
                            shadeIntensity: .8,
                            opacityFrom: .8,
                            opacityTo: .25,
                            stops: [0, 85, 100]
                        }
                    },
                    grid: {
                        show: !1,
                        padding: {
                            top: -20,
                            bottom: -8
                        }
                    },
                    legend: {
                        show: !1
                    },
                    xaxis: {
                        categories: {!! $dateMutation !!},
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                fontSize: "13px",
                                colors: r
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: !1
                        }
                    }
                },
                d = (null !== d && new ApexCharts(d, c).render(), document.querySelector("#assetChart")),
                c = {
                    series: [{
                        name: "Bulan Lalu",
                        data: {!! $assetMonthlyStart !!}
                    }, {
                        name: "Bulan Ini",
                        data: {!! $assetMonthlyEnd !!}
                    }],
                    chart: {
                        type: "bar",
                        height: 80,
                        toolbar: {
                            tools: {
                                download: !1
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "65%",
                            startingShape: "rounded",
                            endingShape: "rounded",
                            borderRadius: 3,
                            dataLabels: {
                                show: !1
                            }
                        }
                    },
                    grid: {
                        show: !1,
                        padding: {
                            top: -30,
                            bottom: -12,
                            left: -10,
                            right: 0
                        }
                    },
                    colors: [config.colors_label.success, config.colors.success],
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        width: 5,
                        colors: r
                    },
                    legend: {
                        show: !1
                    },
                    xaxis: {
                        categories: {!! $dateAsset !!},
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            style: {
                                colors: r,
                                fontSize: "13px"
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: !1
                        }
                    }
                },
                d = (null !== d && new ApexCharts(d, c).render(), document.querySelector("#expensesChart")),
                c = {
                    chart: {
                        height: 130,
                        sparkline: {
                            enabled: !0
                        },
                        parentHeightOffset: 0,
                        type: "radialBar"
                    },
                    colors: [config.colors.primary],
                    series: [78],
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            hollow: {
                                size: "55%"
                            },
                            track: {
                                background: config.colors_label.secondary
                            },
                            dataLabels: {
                                name: {
                                    show: !1
                                },
                                value: {
                                    fontSize: "22px",
                                    color: e,
                                    fontWeight: 500,
                                    offsetY: 0
                                }
                            }
                        }
                    },
                    grid: {
                        show: !1,
                        padding: {
                            left: -10,
                            right: -10,
                            top: -10
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    labels: ["Progress"]
                },
                d = (null !== d && new ApexCharts(d, c).render(), document.querySelector("#totalIncomeChart")),
                c = {
                    chart: {
                        height: 250,
                        type: "area",
                        toolbar: !1,
                        dropShadow: {
                            enabled: !0,
                            top: 14,
                            left: 2,
                            blur: 3,
                            color: config.colors.primary,
                            opacity: .15
                        }
                    },
                    series: [{
                        name: 'Laba Rugi',
                        data: {!! $profitMonthly !!}
                    }],
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        width: 3,
                        curve: "straight"
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: t,
                            shadeIntensity: .8,
                            opacityFrom: .7,
                            opacityTo: .25,
                            stops: [0, 95, 100]
                        }
                    },
                    grid: {
                        show: !0,
                        borderColor: s,
                        padding: {
                            top: -15,
                            bottom: -10,
                            left: 0,
                            right: 0
                        }
                    },
                    xaxis: {
                        categories: {!! $dateProfit !!},
                        labels: {
                            offsetX: 0,
                            style: {
                                colors: r,
                                fontSize: "13px"
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        lines: {
                            show: !1
                        }
                    },
                    yaxis: {
                        labels: {
                            offsetX: -15,
                            style: {
                                fontSize: "13px",
                                colors: r
                            }
                        }
                    }
                };
            null !== d && new ApexCharts(d, c).render()
        }();
    </script>
@endpush
