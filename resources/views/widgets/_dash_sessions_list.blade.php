<div class="card {{ $class }}">
    <!--begin::Header-->
    <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
            <span class="fw-bolder mb-2 text-dark">Today's Sessions  <span class="text-muted fw-bold fs-7"> All Times in UTC</span></span>
            <span class="text-muted fw-bold fs-7">{{ count(App\Models\Session::todaysMeetingSessions()) }}</span>
        </h3>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-5 scroll h-300px">
        <!--begin::Timeline-->
        <div class="timeline-label">
            <!--begin::Item-->
            @if(count(App\Models\Session::todaysMeetingSessions()) == 0)
            <div class="timeline-item">
                <div class="timeline-label fw-bolder text-gray-800 fs-6">00:00</div>
                <div class="timeline-badge">
                    <i class="fa fa-genderless text-dark fs-1"></i>
                </div>
                <div class="fw-mormal timeline-content text-bold text-uppercase ps-3">
                    No Sessions Today
                </div>
            </div>
            @else
            @foreach(App\Models\Session::todaysMeetingSessions() as $s)
            <div class="timeline-item">
                <!--begin::Label-->
                <div class="timeline-label fw-bolder text-gray-800 fs-6">{{ date('G:i', strtotime($s->startTime)) }}</div>
                <!--end::Label-->

                <!--begin::Badge-->
                @if(time() - strtotime($s->startTime) < 3599)
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-success fs-1"></i>
                    </div>
                    <!--end::Badge-->
                @else
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-dark fs-1"></i>
                    </div>
                    <!--end::Badge-->
                @endif
                <!--begin::Text-->
                <div class="fw-mormal timeline-content text-bold text-uppercase ps-3">
                    {{ $s->parent }}
                </div>
                <!--end::Text-->
            </div>
            <!--end::Item-->
            @endforeach
            @endif
        </div>
        <!--end::Timeline-->
    </div>
    <!--end: Card Body-->
</div>
<!--end: List Widget 5-->
