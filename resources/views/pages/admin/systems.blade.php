@if(auth()->user()->admin == 1)
<x-base-layout>
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@append
<!--begin::Card-->
    @if(session('success'))
        <!--begin::Alert-->
        <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row p-5 mb-10">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black"/>
                <rect x="6" y="12" width="7" height="2" rx="1" fill="black"/>
                <rect x="6" y="7" width="12" height="2" rx="1" fill="black"/>
                </svg></span>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Title-->
                <h4 class="mb-2 light">MeetEcho API Information Updated</h4>
                <!--end::Title-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Close-->
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <span class="svg-icon svg-icon-2x svg-icon-light"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black"/>
                    <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black"/>
                    </svg></span>
            </button>
            <!--end::Close-->
        </div>

    @endif
    <div class="col-xl-12 col-xxl-12 col-md-10 col-sm 12">
        <div class="row-g5">
            <div class="col-lg-12">
                <div class="card card-bordered mb-5">
                    <div class="card-body">
                        <button type="button" id="clear_participant_pii" class="btn btn-primary me-5">Clear Participant Pii</button>
                        <button type="button" id="set_meetecho_params" class="btn btn-primary me-5" data-bs-toggle="modal" data-bs-target="#set_meetecho_params_modal">Set MeetEcho Params</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-xl">
            <div class="card-header">
                <h3 class="card-title">Meetings List</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addMeetingModal">
                        Add Meeting
                    </button>
                </div>
            </div>
            <!--begin::Card body-->
            <div class="card-body pt-6">
                @include('pages.admin._meeting_info_table')
            </div>
            <!--end::Card body-->
        </div>
    <!--end::Card-->
    </div>
    <div class="modal fade" tabindex="-1" id="addMeetingModal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Meeting</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="form" action="{{ route('admin.meeting-info.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-xl-5 col-xxl-5 col-sm-12">
                                <div class="form-group row">
                                    <div class="mb-0">
                                        <label class="required col-form-label text-right col-lg-12 col-sm-12">Meeting Number</label>
                                        <input type="text" name="meetingNumber" class="form-control form-control-solid"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="mb-0">
                                        <label class="required col-form-label text-right col-lg-12 col-sm-12">Meeting City</label>
                                        <input type="text" name="meetingCity" class="form-control form-control-solid"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="mb-0">
                                        <label class="required col-form-label text-right col-lg-12 col-sm-12">Meeting Country</label>
                                        <div class="col-lg-8 fv-row">
                                            <select name="meetingCountry" aria-label="Select a Country" data-placeholder="Select a country..." class="form-select form-select-solid form-select-lg fw-bold">
                                                <option value="">Select a Country...</option>
                                                @foreach(\App\Core\Data::getCountriesList() as $key => $value)
                                                    <option data-kt-flag="{{ $value['flag'] }}" value="{{ $key }}" {{ $key === old('country', $info->country ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 fv-row">
                                    <div class="mb-0">
                                        <label class="required col-form-label text-right col-lg-12 col-sm-12">Meeting Timezone</label>
                                        <select name="meetingTZ" aria-label="'Select a Timezone"  data-placeholder="Select a timezone.." class="form-select form-select-solid form-select-lg">
                                            <option value="">{{ __('Select a Timezone..') }}</option>
                                            @foreach(\App\Core\Data::getTimeZonesList() as $key => $value)
                                                <option data-bs-offset="{{ $value['offset'] }}" value="{{ $value['offset'] }}" {{ $key === old('timezone', $info->timezone ?? '') ? 'selected' :'' }}>{{ $value['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-xl-5 col-xxl-5 col-sm-12">
                                <div class="form-group row">
                                    <div class="mb-0">
                                        <label class="required form-label">Start Date</label>
                                        <input name="startDate" class="form-control form-control-solid" placeholder="Pick a Date" id="startDatePicker"/>
                                    </div>
                                    <div class="mb-1">
                                        <label class="required form-label">End Date</label>
                                        <input name="endDate" class="form-control form-control-solid" placeholder="Pick a Date" id="endDatePicker"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="mb-0">
                                        <label class="required form-label">Hackathon Start Date</label>
                                        <input name="hackStartDate" class="form-control form-control-solid" placeholder="Pick a Date" id="hackStartDatePicker"/>
                                    </div>
                                    <div class="mb-0">
                                        <label class="required form-label">Hackathon End Date</label>
                                        <input name="hackEndDate" class="form-control form-control-solid" placeholder="Pick a Date" id="hackEndDatePicker"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Meeting</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="set_meetecho_params_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update MeetEcho Params</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="form" id="updateMeetEchoForm" method="POST" action="/admin/updateMeetEchoParams">
                        @csrf
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">API URL</label>
                            <input name="url" type="text" class="form-control form-control-solid" value="{{\App\Models\MeetingInfo::where('active',1)->first()->meetechoAPIURL}}"/>
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">API Token</label>
                            <input name="token" type="text" class="form-control form-control-solid" value="{{\App\Models\MeetingInfo::where('active',1)->first()->meetechoAPIToken}}"/>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $("#startDatePicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: "Y-M-DD"
                },
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),10)
                }
            );
            $("#endDatePicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: "Y-M-DD"
                },
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),10)
                }
            );
            $("#hackStartDatePicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: "Y-M-DD"
                },
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),10)
                }
            );
            $("#hackEndDatePicker").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: "Y-M-DD"
                },
                minYear: 1901,
                maxYear: parseInt(moment().format("YYYY"),10)
                }
            );

        </script>
        <script type="text/javascript">
            const button = document.getElementById('clear_participant_pii');
            const form = document.getElementById('clearPII');

            button.addEventListener('click', e =>{
                e.preventDefault();

                Swal.fire({
                    html: `<form id="clearPII" method="POST" action="/admin/clearPII">@csrf Are you sure you want to <br><strong>Clear Participant PII</strong></form>`,
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes, Remove it",
                    cancelButtonText: 'Nope, not yet',
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: 'btn btn-primary'
                    }
                }).then((result) => {
                    if (result.isConfirmed){
                        form.submit();
                        Swal.fire('Clearing Pii','', 'success');

                    }
                });
            });
        </script>
    @append
</x-base-layout>
@endif
