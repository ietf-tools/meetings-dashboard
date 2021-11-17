<x-base-layout>

    <div class="row gy-5 gx-xl-8">
        <!--begin::Col-->
        <div class="col-xl-12 col-xxl-12 col-md-12 col-sm-12">
            {{ theme()->getView('widgets/_dash_sessions_day_accordian_chart', array('class' => 'card-xxl-stretch-750 mb-5 mb-xl-8', 'chartCcolor' => 'primary', 'chartHeight' => '175px')) }}
        </div>
        <!--end::Col-->
    </div>

</x-base-layout>
