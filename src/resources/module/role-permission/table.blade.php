@foreach ($data as $row)
<tr>
    <td>
        <div class="form-checkbox">
            <input type="checkbox" class="table-checkbox" value="{{$row->id}}" name="selected_ids[]">
        </div>
    </td>
    <td>{{$row->name}}</td>
    <td>
        @if($row->is_superadmin)
        <span class="badge bg-success">Superadmin</span>
        @else
        <span class="badge bg-secondary"><i>Normal</i></span>
        @endif
    </td>
    <td class="text-end">
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-action">
                <li>
                    <a href="{{adminRoute('admin.role-permission.edit',$row->id)}}" class="dropdown-item">Edit</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="confirmation"
                        data-message="{{__('adminportal.delete_confirmation')}}"
                        data-action="{{adminRoute('admin.role-permission.destroy',$row->id)}}" data-method="DELETE"
                        class="dropdown-item">Delete</a>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach