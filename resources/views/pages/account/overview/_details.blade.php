<!--begin::details View-->
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('Participant Details') }}</h3>
        </div>
        <!--end::Card title-->

        <!--begin::Action-->

        <!--end::Action-->
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        <!--begin::Row-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">{{ __('Full Name') }}</label>
            <!--end::Label-->

            <!--begin::Col-->
            @if($info)
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-dark">{{ $info->username }}</span>
            </div>
            @endif
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">{{ __('Email') }}</label>
            <!--end::Label-->

            <!--begin::Col-->
            @if($info)
            <div class="col-lg-8 fv-row">
                <span class="fw-bold fs-6">{{ $info->email }}</span>
            </div>
            @endif
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">
                {{ __('DataTracker ID') }}
            </label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                @if($info)
                    <span class="fw-bolder fs-6 me-2">
                        {{ $info->dataTrackerID }}
                    </span>
                    <span class="badge badge-success">{{ __('Verified') }}</span>
                @endif


            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->

        <!--end::Input group-->



    </div>
    <!--end::Card body-->
</div>
<!--end::details View-->
