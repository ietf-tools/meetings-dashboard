@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '900px';
    $days = App\Models\Session::currentMeetingSessionsByDay();
@endphp
    <div class="card ">
        <div class="card-header card-header-stretch">
            <h3 class="card-title">Session Attendance</h3>
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                    @if(count($days) > 1)
                        @foreach($days as $d => $key)
                            @if($loop->index == 0)
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_day_{{$loop->index + 1}}">{{ $d }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_day_{{$loop->index + 1}}">{{ $d }}</a>
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
            @if(count($days) > 1)
                @foreach($days as $d => $key)
                    @if($loop->index == 0)
                        <div class="tab-pane fade show active" id="tab_day_{{$loop->index + 1}}" role="tabpanel">
                            @include('widgets.sessions._sessions_chart', $key)
                        </div>
                    @else
                        <div class="tab-pane fade" id="tab_day_{{$loop->index + 1}}" role="tabpanel">
                            @include('widgets.sessions._sessions_chart', $key)
                        </div>
                    @endif
                @endforeach
            @else
                @foreach($days as $d => $key)
                    <div class="tab-pane fade show active" id="tab_day_1" role="tabpanel">{{ $d }}
                        @include('widgets.sessions._sessions_chart', $key)
                    </div>
                @endforeach
            @endif
            </div>
        </div>
    </div>
