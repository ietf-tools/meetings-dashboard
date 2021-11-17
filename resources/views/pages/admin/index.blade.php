@if(auth()->user()->admin == 1)
    <x-base-layout>

        <!--begin::Card-->
        <div class="col-xl-8 col-xxl-8 col-md-6 col-sm 8">
            <div class="card card-xl">
                <!--begin::Card body-->
                <div class="card-body pt-6">
                    @include('pages.admin._user_table')
                </div>
                <!--end::Card body-->
            </div>
        <!--end::Card-->
        </div>
    </x-base-layout>
@else
    @include('pages.index')
@endif
