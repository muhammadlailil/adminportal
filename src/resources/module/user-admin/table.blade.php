@foreach ($data as $row)
<tr>
    <td>
        <div class="form-checkbox">
            <input type="checkbox" class="table-checkbox" value="{{$row->id}}" name="selected_ids[]">
        </div>
    </td>
    <td>
        <div class="profile-table align-items-center">
            <img src="{{asset($row->profile)}}" alt="">
            {{$row->name}}
        </div>
    </td>
    <td>{{$row->email}}</td>
    <td>{{$row->role_name}}</td>
    <td>
        @if($row->status)
        <span class="badge bg-success">Active</span>
        @else
        <span class="badge bg-secondary">Non Active</span>
        @endif
    </td>
    <td class="text-end">
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle btn-action" data-bs-toggle="dropdown"
                aria-expanded="false">
                Action
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-action">
                <li>
                    <a href="{{adminRoute('admin.user-admin.edit',$row->id)}}" class="dropdown-item">Edit</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="confirmation"
                        data-message="{{__('adminportal.delete_confirmation')}}"
                        data-action="{{adminRoute('admin.user-admin.destroy',$row->id)}}" data-method="DELETE"
                        class="dropdown-item">Delete</a>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach