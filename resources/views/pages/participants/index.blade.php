@if(auth()->user()->admin == 1)
<x-base-layout>
    <div class="row gy-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12">
            <div class="card card-custom gutter-b">
                <div class="card-body font-right">
                    <span class="svg-icon svg-icon-info svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000"/>
                            <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"/>
                        </g>
                    </svg></span>
                    <h2 class="text-dark text-end font-weight-bolder mt-3">{{ App\Models\Participant::concurrentSessionLogins() }}</h2>
                    <div class="text-hover-primary mt-1 text-end">Concurrent Session Participants</div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
             <!--begin::Card-->
            <div class="card card-xxl">
                <!--begin::Card body-->
                <div class="card-body pt-6">
                    @include('pages.participants._full_participants_table')
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
@endif
