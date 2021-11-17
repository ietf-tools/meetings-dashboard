<!--begin::Action--->
<td class="text-end">
    <div class="row">
        <div class="col">
    <form method="POST" action="{{ route('session.hide', $id) }}">
        @csrf
        <button class="btn btn-sm btn-light btn-active-light-primary">
            Hide
        </button>
    </form>
        </div>
    </div>
</td>
<!--end::Action--->
