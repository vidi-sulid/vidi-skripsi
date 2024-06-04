@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat {{ Auth::user()->name }} 🎉</h5>
                            <p class="mb-4">Anda telah melakukan peningkatan penjualan <span
                                    class="fw-medium">72%</span>hari ini. Periksa lencana baru Anda di profil Anda.</p>

                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-medium d-block mb-1">Profit</span>
                            <h3 class="card-title mb-2">$12,628</h3>
                            <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +72.80%</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span>Sales</span>
                            <h3 class="card-title text-nowrap mb-1">$4,679</h3>
                            <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.42%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                        <div id="totalRevenueChart" class="px-2"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        2022
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                        <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                        <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                        <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-medium pt-3 mb-2">62% Company Growth</div>

                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-primary p-2"><i
                                            class="bx bx-dollar text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>2022</small>
                                    <h6 class="mb-0">$32.5k</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>2021</small>
                                    <h6 class="mb-0">$41.2k</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block mb-1">Payments</span>
                            <h3 class="card-title text-nowrap mb-2">$2,456</h3>
                            <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i> -14.82%</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card"
                                        class="rounded">
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-medium d-block mb-1">Transactions</span>
                            <h3 class="card-title mb-2">$14,857</h3>
                            <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.14%</small>
                        </div>
                    </div>
                </div>
                <!-- </div>
                                <div class="row"> -->
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title">
                                        <h5 class="text-nowrap mb-2">Profile Report</h5>
                                        <span class="badge bg-label-warning rounded-pill">Year 2021</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <small class="text-success text-nowrap fw-medium"><i class='bx bx-chevron-up'></i>
                                            68.2%</small>
                                        <h3 class="mb-0">$84,686k</h3>
                                    </div>
                                </div>
                                <div id="profileReportChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addon_js')
    <script>
        "use strict";
        ! function() {
            var o = config.colors.cardColor,
                t = config.colors.headingColor,
                e = config.colors.axisColor,
                r = config.colors.borderColor,
                i = document.querySelector("#totalRevenueChart"),
                s = {
                    series: [{
                        name: "2021",
                        data: [18, 7, 15, 29, 18, 12, 9]
                    }, {
                        name: "2020",
                        data: [-13, -18, -9, -14, -5, -17, -15]
                    }],
                    chart: {
                        height: 300,
                        stacked: !0,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "33%",
                            borderRadius: 12,
                            startingShape: "rounded",
                            endingShape: "rounded"
                        }
                    },
                    colors: [config.colors.primary, config.colors.info],
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        curve: "smooth",
                        width: 6,
                        lineCap: "round",
                        colors: [o]
                    },
                    legend: {
                        show: !0,
                        horizontalAlign: "left",
                        position: "top",
                        markers: {
                            height: 8,
                            width: 8,
                            radius: 12,
                            offsetX: -3
                        },
                        labels: {
                            colors: e
                        },
                        itemMargin: {
                            horizontal: 10
                        }
                    },
                    grid: {
                        borderColor: r,
                        padding: {
                            top: 0,
                            bottom: -8,
                            left: 20,
                            right: 20
                        }
                    },
                    xaxis: {
                        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                        labels: {
                            style: {
                                fontSize: "13px",
                                colors: e
                            }
                        },
                        axisTicks: {
                            show: !1
                        },
                        axisBorder: {
                            show: !1
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: "13px",
                                colors: e
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 1700,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "32%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1580,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "35%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1440,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "42%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1300,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "48%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1200,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "40%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 1040,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 11,
                                    columnWidth: "48%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 991,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "30%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 840,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "35%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 768,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "28%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 640,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "32%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 576,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "37%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "45%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 420,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "52%"
                                }
                            }
                        }
                    }, {
                        breakpoint: 380,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "60%"
                                }
                            }
                        }
                    }],
                    states: {
                        hover: {
                            filter: {
                                type: "none"
                            }
                        },
                        active: {
                            filter: {
                                type: "none"
                            }
                        }
                    }
                },
                i = (null !== i && new ApexCharts(i, s).render(), document.querySelector("#growthChart")),
                s = {
                    series: [78],
                    labels: ["Growth"],
                    chart: {
                        height: 240,
                        type: "radialBar"
                    },
                    plotOptions: {
                        radialBar: {
                            size: 150,
                            offsetY: 10,
                            startAngle: -150,
                            endAngle: 150,
                            hollow: {
                                size: "55%"
                            },
                            track: {
                                background: o,
                                strokeWidth: "100%"
                            },
                            dataLabels: {
                                name: {
                                    offsetY: 15,
                                    color: t,
                                    fontSize: "15px",
                                    fontWeight: "500",
                                    fontFamily: "Public Sans"
                                },
                                value: {
                                    offsetY: -25,
                                    color: t,
                                    fontSize: "22px",
                                    fontWeight: "500",
                                    fontFamily: "Public Sans"
                                }
                            }
                        }
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: "dark",
                            shadeIntensity: .5,
                            gradientToColors: [config.colors.primary],
                            inverseColors: !0,
                            opacityFrom: 1,
                            opacityTo: .6,
                            stops: [30, 70, 100]
                        }
                    },
                    stroke: {
                        dashArray: 5
                    },
                    grid: {
                        padding: {
                            top: -35,
                            bottom: -10
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "none"
                            }
                        },
                        active: {
                            filter: {
                                type: "none"
                            }
                        }
                    }
                },
                i = (null !== i && new ApexCharts(i, s).render(), document.querySelector("#profileReportChart")),
                s = {
                    chart: {
                        height: 80,
                        type: "line",
                        toolbar: {
                            show: !1
                        },
                        dropShadow: {
                            enabled: !0,
                            top: 10,
                            left: 5,
                            blur: 3,
                            color: config.colors.warning,
                            opacity: .15
                        },
                        sparkline: {
                            enabled: !0
                        }
                    },
                    grid: {
                        show: !1,
                        padding: {
                            right: 8
                        }
                    },
                    colors: [config.colors.warning],
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        width: 5,
                        curve: "smooth"
                    },
                    series: [{
                        data: [110, 270, 145, 245, 205, 285]
                    }],
                    xaxis: {
                        show: !1,
                        lines: {
                            show: !1
                        },
                        labels: {
                            show: !1
                        },
                        axisBorder: {
                            show: !1
                        }
                    },
                    yaxis: {
                        show: !1
                    }
                },
                i = (null !== i && new ApexCharts(i, s).render(), document.querySelector("#orderStatisticsChart")),
                s = {
                    chart: {
                        height: 165,
                        width: 130,
                        type: "donut"
                    },
                    labels: ["Electronic", "Sports", "Decor", "Fashion"],
                    series: [85, 15, 50, 50],
                    colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
                    stroke: {
                        width: 5,
                        colors: [o]
                    },
                    dataLabels: {
                        enabled: !1,
                        formatter: function(o, t) {
                            return parseInt(o) + "%"
                        }
                    },
                    legend: {
                        show: !1
                    },
                    grid: {
                        padding: {
                            top: 0,
                            bottom: 0,
                            right: 15
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "none"
                            }
                        },
                        active: {
                            filter: {
                                type: "none"
                            }
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "75%",
                                labels: {
                                    show: !0,
                                    value: {
                                        fontSize: "1.5rem",
                                        fontFamily: "Public Sans",
                                        color: t,
                                        offsetY: -15,
                                        formatter: function(o) {
                                            return parseInt(o) + "%"
                                        }
                                    },
                                    name: {
                                        offsetY: 20,
                                        fontFamily: "Public Sans"
                                    },
                                    total: {
                                        show: !0,
                                        fontSize: "0.8125rem",
                                        color: e,
                                        label: "Weekly",
                                        formatter: function(o) {
                                            return "38%"
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                o = (null !== i && new ApexCharts(i, s).render(), document.querySelector("#incomeChart")),
                t = {
                    series: [{
                        data: [24, 21, 30, 22, 42, 26, 35, 29]
                    }],
                    chart: {
                        height: 215,
                        parentHeightOffset: 0,
                        parentWidthOffset: 0,
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
                    legend: {
                        show: !1
                    },
                    markers: {
                        size: 6,
                        colors: "transparent",
                        strokeColors: "transparent",
                        strokeWidth: 4,
                        discrete: [{
                            fillColor: config.colors.white,
                            seriesIndex: 0,
                            dataPointIndex: 7,
                            strokeColor: config.colors.primary,
                            strokeWidth: 2,
                            size: 6,
                            radius: 8
                        }],
                        hover: {
                            size: 7
                        }
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: void 0,
                            shadeIntensity: .6,
                            opacityFrom: .5,
                            opacityTo: .25,
                            stops: [0, 95, 100]
                        }
                    },
                    grid: {
                        borderColor: r,
                        strokeDashArray: 3,
                        padding: {
                            top: -20,
                            bottom: -8,
                            left: -10,
                            right: 8
                        }
                    },
                    xaxis: {
                        categories: ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            show: !0,
                            style: {
                                fontSize: "13px",
                                colors: e
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: !1
                        },
                        min: 10,
                        max: 50,
                        tickAmount: 4
                    }
                },
                i = (null !== o && new ApexCharts(o, t).render(), document.querySelector("#expensesOfWeek")),
                s = {
                    series: [65],
                    chart: {
                        width: 60,
                        height: 60,
                        type: "radialBar"
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: 0,
                            endAngle: 360,
                            strokeWidth: "8",
                            hollow: {
                                margin: 2,
                                size: "45%"
                            },
                            track: {
                                strokeWidth: "50%",
                                background: r
                            },
                            dataLabels: {
                                show: !0,
                                name: {
                                    show: !1
                                },
                                value: {
                                    formatter: function(o) {
                                        return "$" + parseInt(o)
                                    },
                                    offsetY: 5,
                                    color: "#697a8d",
                                    fontSize: "13px",
                                    show: !0
                                }
                            }
                        }
                    },
                    fill: {
                        type: "solid",
                        colors: config.colors.primary
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    grid: {
                        padding: {
                            top: -10,
                            bottom: -15,
                            left: -10,
                            right: -10
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "none"
                            }
                        },
                        active: {
                            filter: {
                                type: "none"
                            }
                        }
                    }
                };
            null !== i && new ApexCharts(i, s).render()
        }();
    </script>
@endsection
