@php

@endphp
@if(auth()->user()->admin == 1)
<x-base-layout>
    @section('styles')
        <link href="https://dashboard.meeting.ietf.org/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    @append
    @section('scripts')
        <script src="https://dashboard.meeting.ietf.org/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    @append
    <div class="row gy-5 g-xl-8 mb-5">
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
                    <h2 class="text-dark text-end font-weight-bolder mt-3"> {{ count($as) }}</h2>
                    <div class="text-hover-primary mt-1 text-end">Total Sessions</div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12">
            <div class="card card-custom gutter-b">
                <div class="card-body font-right">
                    <span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                    </svg></span>
                    <h2 class="text-dark text-end font-weight-bolder mt-3">
                        @if(is_array(App\Models\Session::totalSessionParticipants(request()->route('id'))))
                            {{ count(App\Models\Session::totalSessionParticipants(request()->route('id'))) }}
                        @else
                            {{ App\Models\Session::totalSessionParticipants(request()->route('id')) }}
                        @endif
                    </h2>
                    <div class="text-hover-primary mt-1 text-end">Total Participants</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-5 g-xl-8 mt-5">
        <div class="card ">
            <div class="card-header card-header-stretch">
                <h3 class="card-title">Session Participants</h3>
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                        @if(count($as) > 1)
                            @foreach($as as $s)
                                @if($loop->index == 0)
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_day_{{$loop->index + 1}}">Day {{$loop->index + 1}}</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_day_{{$loop->index + 1}}">Day {{$loop->index + 1}}</a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab_day_1">Day 1</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                @if(count($as) > 1)
                    @foreach($as as $s)
                        @if($loop->index == 0)
                            <div class="tab-pane fade show active" id="tab_day_{{$loop->index + 1}}" role="tabpanel">
                                @include('pages.sessions._session_participant_table', $s)
                            </div>
                        @else
                            <div class="tab-pane fade" id="tab_day_{{$loop->index + 1}}" role="tabpanel">
                                @include('pages.sessions._session_participant_table', $s)
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach($as as $s)
                        <div class="tab-pane fade show active" id="tab_day_1" role="tabpanel">
                            @include('pages.sessions._session_participant_table', $s)
                        </div>
                    @endforeach
                @endif
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
@endif
