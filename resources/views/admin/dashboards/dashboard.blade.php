@extends('layouts.admin')
@section('content')
    {{-- overall report --}}
    <div class="row mb-3">
        <div class="col-2 ms-auto">
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
                            <h4 class="pt-2 text-purple">{{ $enrolls->count() }}</h4>
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
        <div class="col-12 col-lg-6 col-xl-6 col-xxl-4 d-flex">
            <div class="card radius-10 bg-transparent shadow-none w-100">
                <div class="card-body p-0">

                    {{-- Enrolls in Branches --}}
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">Enrolls in Branches</h6>
                            </div>
                            <div class="row py-3">
                                <div class="col">
                                    <div class="by-device-container">
                                        <canvas id="chart5"></canvas>
                                    </div>
                                </div>

                            </div>
                            <div class="row py-1">
                                <div class="col-6 mx-auto">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($branches as $branch)
                                            <li class="list-group-item d-flex align-items-center justify-content-between border-0">
                                                <i class="fa fa-home me-2 text-orange"></i> <span>{{ $branch->branch_name }} - </span> <span>{{ $branch->enrolls->count() }} ({{ $enrolls->count() == 0 ? 0 : number_format(($branch->enrolls->count() * 100) / $enrolls->count()) }}%)</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Revenues in branches --}}
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">Revenues in Branches</h6>
                            </div>
                            <div class="row">
                                <div class="row py-3">
                                    <div class="col">
                                        <div class="by-device-container">
                                            <canvas id="chart6" style="min-height: 100px"></canvas>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row py-1">
                                <div class="col-8 mx-auto">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($branches as $branch)
                                            <li class="list-group-item d-flex align-items-center justify-content-evenly border-0">
                                                <i class="fa fa-home me-2" style="color: #2c31b4"></i> <span>{{ $branch->branch_name }} - </span> <span>&#2547; {{ $branch->incomes->sum('amount') - $branch->expenses->sum('amount') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6 col-xxl-4 d-flex">
            <div class="card radius-10 w-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Enrolls Per Month</h6>

                    </div>
                    <div id="chart7"></div>
                    <div class="d-flex align-items-center gap-5 justify-content-center mt-4 p-3 bg-light radius-10 border">
                        <div class="text-center">
                            <h2 class="mb-3 text-success">{{ $enrolls->count() }}</h2>
                            <p>Total <br> Enrolls</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6 col-xxl-4 d-flex">
            <div class="card radius-10 w-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Income Per Month</h6>

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
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Branch Name</th>
                                    <th>Branch Students</th>
                                    <th>Branch Enrolls</th>
                                    <th>Branch Income</th>
                                    <th>Branch Expense</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                    @php
                                        $students_count = App\Models\Enroll::distinct('user_id')
                                            ->where('branch_id', $branch->id)
                                            ->count();
                                    @endphp
                                    <tr>
                                        <td>2</td>
                                        <td>{{ $branch->branch_name }}</td>
                                        <td>{{ $students_count }}</td>
                                        <td>{{ $branch->enrolls->count() }}</td>
                                        <td>&#2547; {{ $branch->incomes->sum('amount') }}</td>
                                        <td>&#2547; {{ $branch->expenses->sum('amount') }}</td>
                                        <td>&#2547; {{ $branch->incomes->sum('amount') - $branch->expenses->sum('amount') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--end row-->
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
        // chart 5
        new Chart(document.getElementById("chart5"), {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($branches as $branch)
                        "{{ $branch->branch_name }}",
                    @endforeach
                ],
                datasets: [{
                    label: "Enrolls in Branches ",
                    backgroundColor: [
                        @foreach ($branches as $branch)
                            "#ff6632",
                            "#12bf24",
                        @endforeach
                    ],
                    data: [
                        @foreach ($branches as $branch)
                            {{ $branch->enrolls->count() }},
                        @endforeach
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 77,
                legend: {
                    position: 'bottom',
                    display: false,
                    labels: {
                        boxWidth: 8
                    }
                },
                tooltips: {
                    displayColors: false,
                },
            }
        });
    </script>

    <script>
        // chart 6
        new Chart(document.getElementById("chart6"), {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($branches as $branch)
                        "{{ $branch->branch_name }}",
                    @endforeach
                ],
                datasets: [{
                    label: "Revenues in Branches",
                    backgroundColor: [
                        @foreach ($branches as $branch)
                            "#2c31b4",
                            "#32bfff",
                        @endforeach
                    ],
                    data: [
                        @foreach ($branches as $branch)
                            {{ $branch->incomes->sum('amount') - $branch->expenses->sum('amount') }},
                        @endforeach
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 77,
                legend: {
                    position: 'bottom',
                    display: false,
                    labels: {
                        boxWidth: 8
                    }
                },
                tooltips: {
                    displayColors: false,
                },
            }
        });
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
                height: 250,
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
                height: 250,
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
        $('#year').change(function() {
            let yearName = $(this).val();

            let url = "/dashboard?y=" + yearName;
            window.location = url;
        })
    </script>
@endsection
