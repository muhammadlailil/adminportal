@foreach ($data as $row)
<tr>
    <td>
        <div class="profile-table align-items-center">
            <img src="{{asset($row->profile)}}" alt="">
            {{$row->name}}
        </div>
    </td>
    <td>{{$row->title}}</td>
    <td>{{$row->description}}</td>
    <td>
        @if($row->is_read)
        <span class="badge bg-success">READ</span>
        @else
        <span class="badge bg-secondary">UN READ</span>
        @endif
    </td>
    <td class="text-end">
        <a  href="{{route('admin.notification.read',$row->uuid)}}" class="btn btn-secondary btn-action d-inline">
            @lang('adminportal.detail')
        </a>
    </td>
</tr>
@endforeach