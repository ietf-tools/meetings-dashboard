@php
    $nav = array(
        array('title' => 'Overview', 'view' => 'account/overview')
    );
    $pInfo = App\Models\Participant::where('email', auth()->user()->email)->orderBy('meetingID', 'desc')->first();
@endphp

<!--begin::Navbar-->
<div class="card {{ $class }}">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="image"/>
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                    @else
                        <img src="{{ auth()->user()->avatar_url }}" alt="image"/>
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                    @endif
                </div>
            </div>
            <!--end::Pic-->

            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ auth()->user()->first }} {{ auth()->user()->last }}</a>
                            <a href="#">
                                {!! theme()->getSvgIcon("icons/duotone/Design/Verified.svg", "svg-icon-1 svg-icon-primary") !!}
                            </a>
                        </div>
                        <!--end::Name-->

                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                {!! theme()->getSvgIcon("icons/duotone/General/User.svg", "svg-icon-4 me-1") !!}
                                Participant
                            </a>
                            @if($pInfo)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! theme()->getSvgIcon("icons/duotone/Map/Marker1.svg", "svg-icon-4 me-1") !!}
                                    {{$pInfo['city']}}, {{$pInfo['state']}}
                                </a>
                            @endif
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                {!! theme()->getSvgIcon("icons/duotone/Communication/Mail-at.svg", "svg-icon-4 me-1") !!}
                                {{ auth()->user()->email }}
                            </a>
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Stats-->
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {!! theme()->getSvgIcon("icons/duotone/Home/Library.svg", "svg-icon-3 svg-icon-info me-2") !!}
                                    <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="@if($pInfo) {{ App\Models\Participant::participantSessions($pInfo['id']) }} @endif">0</div>
                                </div>
                                <!--end::Number-->

                                <!--begin::Label-->
                                <div class="fw-bold fs-6 text-gray-400">{{ __('Sessions') }}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->

                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {!! theme()->getSvgIcon("icons/duotone/Home/Building.svg", "svg-icon-3 svg-icon-danger me-2") !!}
                                    <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="@if($pInfo) {{ count(App\Models\Participant::where('email', $pInfo->email)->get()) }}@endif">0</div>
                                </div>
                                <!--end::Number-->

                                <!--begin::Label-->
                                <div class="fw-bold fs-6 text-gray-400">{{ __('Meetings') }}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->

                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    {!! theme()->getSvgIcon("icons/duotone/Navigation/Arrow-up.svg", "svg-icon-3 svg-icon-success me-2") !!}
                                    <div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                </div>
                                <!--end::Number-->

                                <!--begin::Label-->
                                <div class="fw-bold fs-6 text-gray-400">{{ __('Total Time') }}</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <!--begin::Navs-->
        <div class="d-flex overflow-auto h-55px">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
            @foreach($nav as $each)
                <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ theme()->getPagePath() === $each['view'] ? 'active' : '' }}" href="{{ $each['view'] ? theme()->getPageUrl($each['view']) : '#' }}">
                            {{ $each['title'] }}
                        </a>
                    </li>
                    <!--end::Nav item-->
                @endforeach
            </ul>
        </div>
        <!--begin::Navs-->
    </div>
</div>
<!--end::Navbar-->
