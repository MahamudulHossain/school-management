
    <li style="text-align: center">
        <a href="{{ url('user/' . $row_id) }}">
            <button class="btn btn-success btn-sm" title="Show">
                <span class="far fa-eye" aria-hidden="true"></span></button>
        </a>
    </li>

@can('UserAccess')
<li style="text-align: center">
        <a href="{{ url('user/' . $row_id . '/edit') }}">
            <button class="btn btn-info btn-sm" title="Edit" style="margin-top: 5px">
                <span class="far fa-edit" aria-hidden="true"></span></button>
        </a>
</li>
@endcan
@can('UserDelete')
<li style="text-align: center">
        <form action="{{ url('user/' . $row_id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" title="Delete" style="margin-top: 5px">
                <span class="fa fa-trash" aria-hidden="true" title="Delete"></span>
            </button>
        </form>
</li>
@endcan
