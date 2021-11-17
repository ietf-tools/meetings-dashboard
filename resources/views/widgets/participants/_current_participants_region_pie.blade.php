@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '250px';
@endphp


<div class="card {{ $class }} mb-5">
    <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
            <span class="fw-bolder mb-2 text-dark">Participant Regions</span>
            <span class="text-muted fw-bold fs-7">Regions Determined by IP Address and Grouped by GeoCode</span>

        </h3>
    </div>
    <!--begin::Body-->
    <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
        <div class="d-flex flex-stack flex-grow-1 px-9 pt-9 pb-3">
            <!--begin::Icon-->
            <div class="symbol symbol-45px">
            </div>
        </div>
        <div id="region-pie-chart" style="height: {{ $chartHeight }}"></div>
    </div>
</div>
@section('custom_javascript')
<script>
    var options = {
          series: [@php
                    $r = App\Models\Participant::currentRegionData();
                    foreach($r as $n){
                        echo $n['value'].',';
                        }
                    @endphp],
          chart: {
          width: '100%',
          type: 'pie',
        },
        labels: [@php
                    $r = App\Models\Participant::currentRegionData();
                    foreach($r as $n){
                        echo '"'.$n['name'].'",';
                        }
                    @endphp],
        theme: {
            mode: 'light',
            palette: 'palette8',
            monochrome: {
                enabled: false
          }
        },
        plotOptions: {
          pie: {
            dataLabels: {
              offset: -5
            }
          }
        },
        title: {
          text: ""
        },
        dataLabels: {
          formatter(val, opts) {
            const name = opts.w.globals.labels[opts.seriesIndex]
            return [name, val.toFixed(1) + '%']
          }
        },
        legend: {
            position: 'bottom',
            show: true
        }
        };

        var chart = new ApexCharts(document.querySelector("#region-pie-chart"), options);
        chart.render();
</script>

@append
