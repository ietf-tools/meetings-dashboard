<!--begin::Action--->
<td class="text-end">
    <div class="row">
        <div class="col">
    <form method="POST" action="{{ route('admin.meeting-info.active', $id) }}">
        @csrf
        <button class="btn btn-sm btn-light btn-active-light-primary">
            Activate
        </button>
    </form>
        </div>
        <div class="col">
    <form method="POST" action="{{ route('admin.meeting-info.destroy', $id) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger btn-active-light-danger">
            Delete
        </button>
    </form>
        </div>
    </div>
</td>
<!--end::Action--->
