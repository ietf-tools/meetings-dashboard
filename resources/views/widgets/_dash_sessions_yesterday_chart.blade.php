@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '900px';
@endphp

<!--begin::Mixed Widget 10-->
<div class="card {{ $class }}">
    <!--begin::Body-->
    <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
        <div class="d-flex flex-stack flex-grow-1 px-9 pt-9 pb-3">
            <!--begin::Icon-->
            <div class="symbol symbol-45px">
                <div class="symbol-label">{!! theme()->getSvgIcon("icons/duotone/General/Binocular.svg", "svg-icon-2x svg-icon-" . $chartCcolor) !!}</div>
            </div>
            <!--end::Icon-->

            <!--begin::Text-->
            <div class="d-flex flex-column text-end">
                <span class="fw-bolder text-gray-800 fs-3">Yesterday's Attendance</span>
                <span class="text-gray-400 fw-bold">{{ date('F jS, Y', time() - 60 * 60 * 24) }}</span>
            </div>
            <!--end::Text-->
        </div>

        <!--begin::Chart-->
        <div class="session-yesterday-chart" data-kt-color="{{ $chartCcolor }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->
    </div>
</div>
<!--end::Mixed Widget 10-->
@section('custom_javascript')
<script>
    var sessionChart = function(p, s) {

            var charts = document.querySelectorAll('.session-yesterday-chart');

            var color;
            var height;
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseLightColor;
            var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');
            var baseColor;
            var options;
            var chart;

            [].slice.call(charts).map(function(element) {
                color = element.getAttribute("data-kt-color");
                height = parseInt(KTUtil.css(element, 'height'));
                baseColor = KTUtil.getCssVariableValue('--bs-' + color);

                options = {
                    series: [{
                        name: 'Participants',
                        data: [@foreach(App\Models\Session::yesterdaysMeetingSessions() as $session) @if(!$session->totalParticipantCount)0,@else {{ $session->totalParticipantCount }}, @endif @endforeach]
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: '300px',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['50%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: [@foreach(App\Models\Session::yesterdaysMeetingSessions() as $session) "{{ $session->parent }}", @endforeach],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        y: 0,
                        offsetX: 0,
                        offsetY: 0,
                        min: 1,
                        decimalsInFloat: 0,
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        type: 'solid'
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
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        padding: {
                            top: 10
                        },
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                chart = new ApexCharts(element, options);
                chart.render();
            });
        }
    sessionChart();
</script>
@append
