

<div class="session-chart-{{$d}}" data-kt-color="{{ $chartCcolor }}" style="height: {{ $chartHeight }}"></div>

@section('scripts')
<script>
    var sessionChart = function() {

            var charts = document.querySelectorAll('.session-chart-{{$d}}');

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
                        data: [@foreach($key as $session) @if(!$session->totalParticipantCount)0,@else {{ $session->totalParticipantCount }}, @endif @endforeach]
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
                        categories: [@foreach($key as $session) "{{ $session->parent }}", @endforeach],
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
