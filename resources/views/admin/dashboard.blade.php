<x-admin-app-layout>
    
    @push('title')
    <title>الصفحة الرئيسية</title>
    @endpush

    <x-breadcrumb title="الصفحة الرئيسية" :breadcrumbs='["الصفحة الرئيسية" => "active"]'></x-breadcrumb>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center mb-9">
                        <div>
                            <h5 class="card-title fw-semibold">
                                الاستفسارات
                                (0)
                            </h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 text-nowrap">
                            <tbody>
                                {{-- <tr>
                                    <td class="ps-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Irpun Wicaksono</h6>
                                                <span class="fs-2">irpun@gmail.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="ps-0">
                                        <span>React Js - Online Classes</span>
                                    </td>
                                    <td class="ps-0">
                                        <h6 class="mb-0">$50.00</h6>
                                    </td>
                                    <td class="text-end ps-0">
                                        <span class="badge bg-light-warning text-warning rounded-pill">
                                            <span class="round-8 bg-warning rounded-circle d-inline-block me-1"></span>
                                            progress
                                        </span>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center mb-9">
                        <div>
                            <h5 class="card-title fw-semibold">
                                التسجيلات
                                (0)
                            </h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 text-nowrap">
                            <tbody>
                                {{-- <tr>
                                    <td class="ps-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Irpun Wicaksono</h6>
                                                <span class="fs-2">irpun@gmail.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="ps-0">
                                        <span>React Js - Online Classes</span>
                                    </td>
                                    <td class="ps-0">
                                        <h6 class="mb-0">$50.00</h6>
                                    </td>
                                    <td class="text-end ps-0">
                                        <span class="badge bg-light-warning text-warning rounded-pill">
                                            <span class="round-8 bg-warning rounded-circle d-inline-block me-1"></span>
                                            progress
                                        </span>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="border-bottom">
                    <div class="row gx-0">
                        <div class="col-md-6 border-end">
                            <div class="p-4 py-3 py-md-4">
                            <p class="fs-4 text-primary mb-0">
                                <span class="text-primary">
                                    <span class="round-8 bg-primary rounded-circle d-inline-block me-1"></span>
                                </span>
                                عدد المسجلين
                            </p>
                            <h3 class=" mt-2 mb-0">0</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 py-3 py-md-4">
                                <p class="fs-4 text-info mb-0">
                                    <span class="text-info">
                                        <span class="round-8 bg-info rounded-circle d-inline-block me-1"></span>
                                    </span>
                                    الاستفسارات
                                </p>
                                <h3 class=" mt-2 mb-0">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <h5 class="card-title fw-semibold">
                            عدد المقدمين و المسجلين
                        </h5>
                    </div>
                    <div class="w-100">
                        <div class="mt-4">
                            <div id="financial"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script>
            $(function() {
                var chart = {
                    series: [{
                            name: "المسجلين",
                            data: [0, 0, 0, 0, 0, 0,],
                        },
                        {
                            name: "الاستفسارات",
                            data: [0, 0, 0, 0, 0, 0,],
                        },
                    ],
                    chart: {
                        toolbar: {
                            show: false,
                        },
                        type: "line",
                        fontFamily: "Plus Jakarta Sans', sans-serif",
                        foreColor: "#adb0bb",
                        height: 200,
                    },
                    colors: ["#fa896b", "#615dff"],
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: false,
                    },
                    stroke: {
                        curve: "smooth",
                        width: 3,
                    },
                    grid: {
                        borderColor: "rgba(0,0,0,0.1)",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: false,
                            },
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0,
                        },
                    },
                    xaxis: {
                        categories: [
                            "1-10 Aug",
                            "11-20 Aug",
                            "21-30 Aug",
                            "1-10 Sept",
                            "11-20 Sept",
                            "21-30 Sept",
                        ],
                    },
                    yaxis: {
                        tickAmount: 4,
                    },
                    tooltip: {
                        theme: "dark",
                    },
                };

                var chart = new ApexCharts(document.querySelector("#financial"), chart);
                chart.render();
            });
        </script>
    @endpush

</x-admin-app-layout>
