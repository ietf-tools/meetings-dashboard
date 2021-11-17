<x-base-layout>
    <!--begin::Row-->
    <div class="row gy-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-xxl-4">
            {{ theme()->getView('widgets/_dash_users', array('class' => 'card-xxl-stretch', 'chartCcolor' => 'primary', 'chartHeight' => '125px')) }}
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-4">
            {{ theme()->getView('widgets/reports/_report_meetings_list', array('class' => 'card-xxl-stretch')) }}
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-4">
            {{ theme()->getView('widgets/reports/_report_meetings_regions_pie', array('class' => 'card-xxl-stretch mb-5 mb-xl-8', 'chartCcolor' => 'primary', 'chartHeight' => '250px')) }}
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row gy-5 gx-xl-8">
        <!--begin::Col-->
        <div class="col-xl-6 col-xxl-6 col-md-6 col-sm-12">
            {{ theme()->getView('widgets/reports/_report_meetings_multiple_sessions_chart', array('class' => 'card-xxl-stretch-500 mb-5 mb-xl-8', 'chartCcolor' => 'primary', 'chartHeight' => '175px')) }}
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-base-layout>


