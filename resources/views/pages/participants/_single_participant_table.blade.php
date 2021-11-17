<!--begin::Table-->
<!--begin::Table-->
@php
    $logins = App\Models\Participant::participantSessionLogins($s);
@endphp
<table id="login_table" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
    <thead>
        <tr class="fw-bolder fs-6 text-gray-800 px-7">
            <th>Session</th>
            <th>Date</th>
            <th>Login</th>
            <th>Logout</th>
            <th>Total Time</th>
        </tr>
    </thead>
    <tbody>
        @if($logins)
            @foreach($logins as $login)
                @foreach ($login as $l)
                    <tr>
                        <td>{{ App\Models\Session::where('id', $l->wgID)->pluck('parent')->first() }}</td>
                        <td>
                            @php
                                $ld = date_create($l->wgDate);
                                echo date_format($ld, "M d, Y")
                            @endphp
                        <td>
                            @php
                                $li = date_create($l->login);
                                echo date_format($li, "H:i:s")
                            @endphp
                        </td>
                        <td>
                            @php
                                $lo = date_create($l->logout);
                                echo date_format($lo, "H:i:s")
                            @endphp
                        <td>
                            @php
                            $li = date_create($l->login);

                            $t = date_diff($li, $lo);
                            echo $t->format('%i mins');
                            @endphp
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endif
    </tbody>
</table>
<!--end::Table-->

{{-- Inject Scripts --}}
@section('scripts')
    <script>
        $("#login_table").DataTable({
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
