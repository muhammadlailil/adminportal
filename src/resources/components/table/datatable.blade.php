@php
$filter_column = request('filter_column');
$limit = request('limit');
@endphp
{{@$html}}
<div class="header-datatable d-flex justify-content-between">
    <div class="left-side d-flex align-items-center">
        <form action="" method="get" id="form_data_table_filter">
            {!!input_query(['search']) !!}
            <div class="input-icon input-search" title="Enter untuk menjalankan pencarian">
                <input type="text" name="search" class="form-control" placeholder="Search Data ..." value="{{request('search')}}">
                <i class="isax icon-search-normal-1 icon"></i>
            </div>
        </form>
        @if(@$button['filter'])
        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-filter-data" class="btn btn-light btn-icon me-2">
            <i class="isax icon-setting-4 icon"></i>
            @lang('adminportal.filter')
        </a>
        @endif
        @if(@$button['import'])
        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-import-data" class="btn btn-light btn-icon  me-2">
            <i class="isax icon-import icon"></i>
            @lang('adminportal.import')
        </a>
        @endif
        @if(@$button['export'])
        <a href="javascript:;"  data-bs-toggle="modal" data-bs-target="#modal-export-data" class="btn btn-light btn-icon  me-2">
            <i class="isax icon-export icon"></i>
            @lang('adminportal.export')
        </a>
        @endif
    </div>
    <div class="right-side d-flex">
        {{@$buttons}}
        @if(@$button['bulkAction'])
        <div id="btn-bulk-action" class="d-none">
            <a href="javascript:;" class="btn btn-dark text-upper" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="isax icon-task-square icon"></i>
                @lang('adminportal.bulk_action')
            </a>
            <ul class="dropdown-menu  p-0 shadow-sm">
                <li>
                    <a href="javascript:;" class="dropdown-item p-10 action" data-action="delete">
                        @lang('adminportal.delete_selected')
                    </a>
                </li>
                {{@$actions_selected}}
            </ul>
        </div>
        @endif
        @if(@$button['add'])
        <a href="{{route("{$route}.create",[
            'return_url' => urlencode(request()->fullUrl())
        ])}}" class="btn btn-dark btn-icon text-upper ms-2" id="btn-add-table">
            <i class="isax icon-add-circle icon"></i>
            @lang('adminportal.add_data')
        </a>
        @endif
    </div>
</div>


@php
    $tableClass = ($result->count()>=5 || count($columns)>=10)?'table-responsive':'';
    $bulkAction = '';
    if(@$button['bulkAction']){
        $bulkAction = route("{$route}.bulk-action");
    }
@endphp
<form action="{{$bulkAction}}" id="form-data-table" method="POST">
    @csrf
    <div class="{{$tableClass}} datatable-content">
        <table id="app-datatable" class="table datatable" cellpadding="1" cellspacing="1">
            <thead>
                <tr>
                    @if(@$button['bulkAction'])
                    <th class="th-checkbox">
                        <div class="form-checkbox">
                            <input type="checkbox" id="input_checkall_datatable">
                        </div>
                    </th>
                    @endif
                    @foreach($columns as $column)
                        @if($filter_column && @$filter_column[$column['name']])
                            @if(@$filter_column[$column['name']]=='asc')
                                @php
                                $icon = '<i class="isax sort-icon icon-arrow-up-3"></i>';
                                $sort = 'desc';
                                @endphp
                            @else
                                @php
                                $icon = '<i class="isax sort-icon icon-arrow-down"></i>';
                                $sort = 'asc';
                                @endphp
                            @endif
                        @else
                            @php
                            $icon = '<i class="isax sort-icon icon-arrow-down"></i><i class="isax sort-icon icon-arrow-up-3"></i>';
                            $sort = 'desc';
                            @endphp
                        @endif
                    <th>
                        <a href="{{urlFilterColumn($column['name'],$sort)}}">{{@$column['label']}} {!! $icon !!}</a>
                    </th>
                    @endforeach
                    @if(@$button['tableAction'])
                    <th class="text-end">@lang('adminportal.actions')</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                {{$slot}}
                @if(!$result->count())
                <tr>
                    <td class="no-data" colspan="{{count($columns)+2}}">@lang('adminportal.no_data_available')</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</form>
<div class="d-flex paginate-footer justify-content-between">
    <div>
        {{ $result->appends(request()->query())->onEachSide(2)->links() }}
    </div>
    <div class="paginate-information">
        @php
        $from = $result->count() ? ($result->perPage() * $result->currentPage() - $result->perPage() + 1) : 0;
        $to = $result->perPage() * $result->currentPage() - $result->perPage() + $result->count();
        @endphp
        {{$from}} - {{$to}} From {{$result->total()}}
    </div>
</div>