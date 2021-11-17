<div class="card card-xl-stretch mb-5 mb-xl-8">
    <div class="card-header align-items-center border-0 mt-3">
        <h3 class="card-title align-items-start flex-column">
            <span class="fw-bolder text-dark fs-3">Meeting List</span>
            <span class="text-gray-400 mt-2 fw-bold fs-6">List of Meetings over the years..</span>
        </h3>
    </div>
    <div class="card-body scroll pt-5">
        @foreach(App\Models\MeetingInfo::where('show', 1)->orderBy('meetingNumber', 'desc')->get() as $m)
            <div class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
                <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                    <p class="fs-5 text-gray-800 text-hover-primary fw-bolder">IETF Meeting {{ $m->meetingNumber }}<p>
                    <span class="text-gray-400 fw-bold fs-7 my-1">{{$m->meetingCity}} , {{ $m->meetingCountry}}</span>
                </div>
                <div class="text-end py-lg-0 py-2">
                    <span class="text-gray-800 fw-boldest fs-3">{{ count(App\Models\MeetingInfo::participantCount($m->meetingNumber)) }}</span>
                    <span class="text-gray-400 fs-7 fw-bold d-block">Total Participants</span>
                </div>
            </div>
        @endforeach
    </div>
</div>




