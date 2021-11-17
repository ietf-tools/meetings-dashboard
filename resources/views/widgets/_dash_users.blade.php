@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '175px';

    $pctLast5Days = App\Models\ParticipantCount::whereDate('check_time', '>', Carbon\Carbon::now()->subDays(5))->get();
    $pctPeriod = Carbon\CarbonPeriod::create($pctLast5Days->first()->check_time, $pctLast5Days->last()->check_time);
    $pCount = array();
    $i = 0;
    foreach($pctPeriod as $day){
        //return date('D', strtotime($day));
        $pCount[$i]['day'] = date('D', strtotime($day));
        //return $pCount->day;
        $pCount[$i]['date'] = date('Y-m-d', strtotime($day));
        //return $pCount->date;
        $pCount[$i]['max'] = App\Models\ParticipantCount::whereDate('check_time', '=', $pCount[$i]['date'])->max('pCount');
        //return $pCount->max;
        $i++;
        }
    //print_r($pCount);
@endphp

<div class="card {{ $class }}">
    <!--begin::Header-->
    <div class="card-header border-0 bg-{{ $chartCcolor }} py-5">
        <h3 class="card-title fw-bolder text-white">Meeting Statistics</h3>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body p-0 h-400px">
        <!--begin::Chart-->
        <div class="users-statistics-widget card-rounded-bottom bg-{{ $chartCcolor }}" data-kt-color="{{ $chartCcolor }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->

        <!--begin::Stats-->
        <div class="card-p mt-n20 position-relative">
            <!--begin::Row-->
            <div class="row g-0">
                <!--begin::Col-->
                <div class="col bg-light-warning px-6 py-8 rounded-2 me-7 mb-7">
                    {!! theme()->getSvgIcon("icons/duotone/General/User.svg", "svg-icon-3x svg-icon-warning d-block my-2") !!}
                    <h2 class="text-dark fw-bold">
                        {{ App\Models\Participant::onlineCount() }}
                    </h2>
                    <p class="text-warning fw-bold fs-6">
                        Participants Online
                    </p>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col bg-light-primary px-6 py-8 rounded-2 mb-7">
                    {!! theme()->getSvgIcon("icons/duotone/Communication/Group.svg", "svg-icon-3x svg-icon-primary d-block my-2") !!}
                    <h2 class="text-dark fw-bold">
                        {{ App\Models\Participant::totalCount() }}
                    </h2>
                    <p class="text-primary fw-bold fs-6">
                        Total Participants
                    </p>
                </div>
            </div>
            <div class="row g-0">
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col bg-light-danger px-6 py-8 rounded-2 me-7">
                    {!! theme()->getSvgIcon("icons/duotone/Home/Library.svg", "svg-icon-3x svg-icon-danger d-block my-2") !!}
                    <h2 class="text-dark fw-bold">
                        {{ count(App\Models\Session::todaysMeetingSessions()) }}
                    </h2>
                    <p class="text-danger fw-bold fs-6 mt-2">
                        Sessions Today &nbsp; &nbsp;
                    </p>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col bg-light-success px-6 py-8 rounded-2"">
                    {!! theme()->getSvgIcon("icons/duotone/Home/Library.svg", "svg-icon-3x svg-icon-success d-block my-2") !!}
                    <h2 class="text-dark fw-bold">
                        {{ count(App\Models\Session::currentMeetingSessions()) }}
                    </h2>
                    <p class="text-success fw-bold fs-6 mt-2">
                        Total Sessions
                    </p>
                </div>
                <!--end::Col-->
            </div>
        </div>
        <!--end::Stats-->
    </div>
    <!--end::Body-->
</div>
@section('scripts')
    <script>
        var initUsersStatisticsWidget = function() {
            var charts = document.querySelectorAll('.users-statistics-widget');

            [].slice.call(charts).map(function(element) {
                var height = parseInt(KTUtil.css(element, 'height'));

                if ( !element ) {
                    return;
                }

                var color = element.getAttribute('data-kt-chart-color');

                var labelColor = KTUtil.getCssVariableValue('--bs-' + 'gray-800');
                var baseColor = KTUtil.getCssVariableValue('--bs-' + color);
                var lightColor = KTUtil.getCssVariableValue('--bs-light-' + color );

                var options = {
                    series: [{
                        name: 'Participants',
                        data: [@foreach($pCount as $m){{ $m['max'] }},@endforeach]
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'area',
                        height: height,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [baseColor]
                    },
                    xaxis: {
                        categories: [@foreach($pCount as $p)"{{ $p['day'] }}",@endforeach],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: '#E4E6EF',
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 900,
                        labels: {
                            show: false,
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            stops: [0, 100]
                        }
                    },
                    colors: [baseColor],
                    markers: {
                        colors: [baseColor],
                        strokeColor: [lightColor],
                        strokeWidth: 3
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            });
        }
        initUsersStatisticsWidget();
    </script>
@append
