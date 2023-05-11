@php
$filter_column = request('filter_column');
$limit = request('limit');
@endphp
{{@$html}}
<div class="header-datatable d-flex justify-content-between">
    <div class="left-side d-flex align-items-center">
          <div class="input-icon input-search" title="Enter untuk menjalankan pencarian">
               <input type="text" name="search" class="form-control" placeholder="Search Data ..." value="{{request('search')}}">
               <i class="isax icon-search-normal-1 icon"></i>
          </div>
        @if(@$button['filter'])
        <a href="" class="btn btn-light btn-icon me-2">
            <i class="isax icon-setting-4 icon"></i>
            @lang('adminportal.filter')
        </a>
        @endif
        @if(@$button['import'])
        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-import-data" class="btn btn-light btn-icon me-2">
            <i class="isax icon-import icon"></i>
            @lang('adminportal.import')
        </a>
        @endif
        @if(@$button['export'])
        <a href="javascript:;"  data-bs-toggle="modal" data-bs-target="#modal-export-data" class="btn btn-light btn-icon me-2">
            <i class="isax icon-export icon"></i>
            @lang('adminportal.export')
        </a>
        @endif
    </div>
    <div class="right-side d-flex">
        {{@$buttons}}
        @if(@$button['bulkAction'])
        <div id="btn-bulk-action" class="d-none">
            <a href="javascript:;" class="btn btn-dark" data-bs-toggle="dropdown" aria-expanded="false">
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
    $bulkAction = '';
    if(@$button['bulkAction']){
        $bulkAction = route("{$route}.bulk-action");
    }
@endphp

<form action="{{$bulkAction}}" id="form-data-table" method="POST">
    @csrf
    <div class="table-responsive datatable-content">
        <table id="js-datatable" class="table datatable" data-url="{{route("{$route}.datatable")}}" cellpadding="1" cellspacing="1" data-empty="@lang('adminportal.no_data_available')">
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
                    <th>{{@$column['label']}} </th>
                    @endforeach
                    @if(@$button['tableAction'])
                    <th class="text-end">@lang('adminportal.actions')</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                {{$slot}}
            </tbody>
        </table>
    </div>
</form>

@push('js')
<style>
    .text-webkit-right {
        text-align: -webkit-right;
    }
    .dt-container{
        overflow: unset !important
    }
</style>
<link rel="stylesheet" href="https://jstable.github.io/css/jstable.css">
<script src="https://jstable.github.io/js/polyfill-fetch.min.js"></script>
<script src="https://jstable.github.io/js/jstable.es5.min.js"></script>
<script src="{{asset('adminportal/js/jstable.js?'.date('YmdHis'))}}"></script>
@endpush