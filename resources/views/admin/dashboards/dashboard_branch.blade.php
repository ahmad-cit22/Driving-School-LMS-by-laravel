@extends('layouts.admin')
@section('content')
    {{-- overall report --}}
    <div class="row mb-4">
        <div class="col-10 text-center">
            <h4>Branch Report - {{ $branch_name }}</h4>
        </div>
        <div class="col-2">
            <div class="row">
                <div class="col">
                    <select name="year" id="year" class="select2 form-select">
                        <option>Select A Year</option>
                        <option {{ $current_year == $selected_year ? 'selected' : '' }} value="{{ $current_year }}">{{ $current_year }}</option>
                        <option {{ $current_year - 1 == $selected_year ? 'selected' : '' }} value="{{ $current_year - 1 }}">{{ $current_year - 1 }}</option>
                        <option {{ $current_year - 2 == $selected_year ? 'selected' : '' }} value="{{ $current_year - 2 }}">{{ $current_year - 2 }}</option>
                        <option {{ $current_year - 3 == $selected_year ? 'selected' : '' }} value="{{ $current_year - 3 }}">{{ $current_year - 3 }}</option>
                        <option {{ $current_year - 4 == $selected_year ? 'selected' : '' }} value="{{ $current_year - 4 }}">{{ $current_year - 4 }}</option>
                        <option {{ $current_year - 5 == $selected_year ? 'selected' : '' }} value="{{ $current_year - 5 }}">{{ $current_year - 5 }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-5">
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body p-2">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3 bg-light-pink">
                            <h5>Total Students</h5>
                            <h4 class="pt-2 text-pink">{{ $student_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body p-2">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3 bg-light-purple">
                            <h5>Total Enrolls</h5>
                            <h4 class="pt-2 text-purple">{{ $enrolls_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body p-2">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3 bg-light-success">
                            <h5>Total Income</h5>
                            <h4 class="pt-2 text-success">&#2547; {{ $income->sum('amount') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body p-2">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3 bg-light-success">
                            <h5>Total Expense</h5>
                            <h4 class="pt-2 text-success">&#2547; {{ $expense->sum('amount') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body p-2">
                    <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                        <div class="w-100 p-3 bg-light-success">
                            <h5>Total Revenue</h5>
                            <h4 class="pt-2 text-success">&#2547; {{ $total_revenue }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->


    <div class="row">

        <div class="col-12 col-lg-6 col-xl-6 d-flex">
            <div class="card radius-10 w-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Enrolls Per Month</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="chart7"></div>
                    <div class="d-flex align-items-center gap-5 justify-content-center mt-4 p-3 bg-light radius-10 border">
                        <div class="text-center">
                            <h2 class="mb-3 text-success">{{ $enrolls_count }}</h2>
                            <p>Total <br> Enrolls</p>
                        </div>
                        {{-- <div class="border-end sepration"></div>
                        <div class="text-center">
                            <h2 class="mb-3">2.56</h2>
                            <p>AVG per <br> Customer</p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6 d-flex">
            <div class="card radius-10 w-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Income Per Month</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="chart8"></div>
                    <div class="d-flex align-items-center gap-5 justify-content-center mt-4 p-3 bg-light radius-10 border">
                        <div class="text-center">
                            <h2 class="mb-3 text-success">&#2547; {{ $income->sum('amount') }}</h2>
                            <p>Total <br> Income</p>
                        </div>
                        {{-- <div class="border-end sepration"></div>
                        <div class="text-center">
                            <h2 class="mb-3">2.56</h2>
                            <p>AVG per <br> Customer</p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h4 class="mb-2">Overall Report</h4>
                        </div>
                        <div class="col">
                            {{-- <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                <div class="dropdown">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Branch ID</th>
                                    <th>Branch Name</th>
                                    <th>Total Students</th>
                                    <th>Total Enrolls</th>
                                    <th>Total Income</th>
                                    <th>Total Expense</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>{{ $branch_name }}</td>
                                    <td>{{ $student_count }}</td>
                                    <td>{{ $enrolls_count }}</td>
                                    <td>&#2547; {{ $branch_income }}</td>
                                    <td>&#2547; {{ $branch_expense }}</td>
                                    <td>&#2547; {{ $branch_revenues }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/backend') }}/plugins/chartjs/js/Chart.min.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="{{ asset('assets/backend') }}/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    {{-- <script src="{{ asset('assets/backend') }}/js/index2.js"></script> --}}
    <script>
        new PerfectScrollbar(".best-product")
    </script>

    <script>
        //  chart 7

        var options = {
            series: [{
                name: "Enrolls",
                data: [{{ $jan }}, {{ $feb }}, {{ $mar }}, {{ $apr }}, {{ $may }}, {{ $jun }}, {{ $jul }}, {{ $aug }}, {{ $sep }}, {{ $oct }}, {{ $nov }}, {{ $dec }}]
            }],
            chart: {
                foreColor: '#9a9797',
                type: "area",
                //width: 130,
                height: 200,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 15,
                    blur: 4,
                    opacity: .22,
                    color: "#12bf24"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#2c31b4"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "35%",
                    endingShape: "rounded"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: 3,
                curve: "straight"
            },
            colors: ['#2c31b4'],
            xaxis: {
                categories: ["Jan", 'Feb', "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ]
            },
            tooltip: {
                theme: "dark",
                fixed: {
                    enabled: !1
                },
                x: {
                    show: !1
                },
                y: {
                    title: {
                        formatter: function(e) {
                            return ""
                        }
                    }
                },
                marker: {
                    show: !1
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart7"), options);
        chart.render();
    </script>

    <script>
        //  chart 8

        var options = {
            series: [{
                name: "Income",
                data: [{{ $janInc }}, {{ $febInc }}, {{ $marInc }}, {{ $aprInc }}, {{ $mayInc }}, {{ $junInc }}, {{ $julInc }}, {{ $augInc }}, {{ $sepInc }}, {{ $octInc }}, {{ $novInc }}, {{ $decInc }}]
            }],
            chart: {
                foreColor: '#9a9797',
                type: "area",
                //width: 130,
                height: 200,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 15,
                    blur: 4,
                    opacity: .22,
                    color: "#12bf24"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#12bf24"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "35%",
                    endingShape: "rounded"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: 3,
                curve: "straight"
            },
            colors: ['#12bf24'],
            xaxis: {
                categories: ["Jan", 'Feb', "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ]
            },
            tooltip: {
                theme: "dark",
                fixed: {
                    enabled: !1
                },
                x: {
                    show: !1
                },
                y: {
                    title: {
                        formatter: function(e) {
                            return ""
                        }
                    }
                },
                marker: {
                    show: !1
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart8"), options);
        chart.render();
    </script>

    <script>
        // // window.location = 'dashboard/{2023}';
        // let year = {{ $current_year }};
        // let url = "{{ route('admin.index', ':id') }}";
        // url = url.replace(':id', year);
        // $.ajax({
        //     method: 'get',
        //     url: url,
        //     success: function(response) {
        //         alert();
        //     }
        // })

        $('#year').change(function() {
            let yearName = $(this).val();

            let url = "/dashboard?y=" + yearName;
            window.location = url;
        })
    </script>
@endsection
