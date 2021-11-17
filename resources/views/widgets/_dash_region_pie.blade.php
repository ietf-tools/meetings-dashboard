@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '175px';
@endphp

<!--begin::Mixed Widget 10-->
<div class="card {{ $class }} mb-5">
    <!--begin::Body-->
    <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
        <div class="d-flex flex-stack flex-grow-1 px-9 pt-9 pb-3">
            <!--begin::Icon-->
            <div class="symbol symbol-45px">
            </div>
            <!--end::Icon-->

            <!--begin::Text-->
            <div class="d-flex flex-column text-end">
                <span class="fw-bolder text-gray-800 fs-3">Participant Regions</span>
            </div>
            <!--end::Text-->
        </div>
        <div id="region_pie" data-kt-color="{{ $chartCcolor }}" style="height: {{ $chartHeight }}"></div>
    </div>
</div>
