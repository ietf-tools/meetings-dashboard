<!--begin::Container-->
<div id="kt_content_container" class="{{ theme()->printHtmlClasses('content-container', false) }}">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card Body-->
        <div class="card-body fs-6 p-10 p-lg-15">
            {{ $slot }}
        </div>
        <!--end::Card Body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->
