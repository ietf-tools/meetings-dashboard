<!--begin::Table-->
@php
    $parts = App\Models\Participant::where('meetingID', $s->meetingNumber)->where('hide', 0)->get();
@endphp
<table id="participants_in_{{ $s->title }}" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
        <tr class="fw-bolder fs-6 text-gray-800 px-7">
            <th>Participant</th>
            <th>Email</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
        </tr>
    </thead>
    @php
        $ps = explode(',',$s->participants);
        //print_r($ps);
    @endphp
    <tbody>
    @if($ps)
        @foreach($ps as $p)
            @if($parts->where('id', $p)->first())
                <tr>
                    <td><a href="/participants/{{$p}}/index">{{ $parts->where('id', $p)->pluck('username')->first() }}</a></td>
                    <td>{{ $parts->where('id', $p)->pluck('email')->first() }}</td>
                    <td>{{ $parts->where('id', $p)->pluck('city')->first() }}</td>
                    <td>{{ $parts->where('id', $p)->pluck('state')->first() }}</td>
                    <td>{{ $parts->where('id', $p)->pluck('country')->first() }}</td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>
<!--end::Table-->

{{-- Inject Scripts --}}
@section('scripts')
    <script>
        $("#participants_in_{{ $s->title }}").DataTable({
            "language": {
            "lengthMenu": "Show _MENU_",
            },
            "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
    </script>
@append
