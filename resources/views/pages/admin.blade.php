@if(auth()->user()->admin == 1)
<x-base-layout>

    <!--begin::Row-->
    <div class="row gy-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-xxl-4">
            {{ theme()->getView('widgets/admin/_admin_users_table', array('class' => 'card-xxl-stretch')) }}

        </div>
        <!--end::Col-->

    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row gy-5 gx-xl-8">
    </div>
    <!--end::Row-->


</x-base-layout>
@endif

