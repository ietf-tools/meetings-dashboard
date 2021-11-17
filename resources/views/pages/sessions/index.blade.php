@if(auth()->user()->admin == 1)
<x-base-layout>
    <div class="row gy-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-xxl-10 col-xl-10 col-md-10 col-sm-8">
             <!--begin::Card-->
            <div class="card card-xxl">
                <!--begin::Card body-->
                <div class="card-body pt-6">
                    @include('pages.sessions._full_sessions_table')
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
@endif
