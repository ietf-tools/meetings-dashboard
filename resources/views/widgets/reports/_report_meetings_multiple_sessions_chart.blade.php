@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '500px';
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
                <span class="fw-bolder text-gray-800 fs-3">Participants Session Attendance</span>
                <span class="text-gray-400 fw-bold">How many participants attended #'s of Sessions</span>
            </div>
            <!--end::Text-->
        </div>

        <!--begin::Chart-->
        <div id="participant-attendance-chart" class="participant-attendance-chart" data-kt-color="{{ $chartCcolor }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->
    </div>
</div>
<!--end::Mixed Widget 10-->
@section('custom_javascript')
@php
    $m = App\Models\Report::participantSessionCount();
    $k = array_keys($m);

@endphp

<script>
    var options = {
        series: [{
            name: 'Only One',
            data: [@foreach($m as $one){{ $one[0]}},@endforeach]
            }, {
            name: 'Two to Five',
            data: [@foreach($m as $two){{ $two[1]}},@endforeach]
            }, {
            name: 'Six to Ten',
            data: [@foreach($m as $three){{ $three[2]}},@endforeach]
            }, {
            name: 'Ten Or More',
            data: [@foreach($m as $four){{ $four[3]}},@endforeach]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: true,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
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
            categories: [@foreach($k as $key) "{{$key}}",@endforeach],
        },
        yaxis: {
            title: {
                text: 'Meetings'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                return  val + " Participants"
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#participant-attendance-chart"), options);
    chart.render();
</script>
@append
