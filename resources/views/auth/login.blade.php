<x-auth-layout>

    <!--begin::Signin Form-->

    <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">
                {{ __('Sign In to IETF Dashboard') }}
            </h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->



        <!--begin::Actions-->
        <div class="text-center">

            <!--begin::IETF link-->
            <a href="{{ url('/auth/redirect/okta') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-primary btn-lg w-100 mb-5">
                {{ __('Login with DataTracker') }}
            </a>
            <!--end::Google link-->
        </div>
        <!--end::Actions-->
    <!--end::Signin Form-->

</x-auth-layout>
