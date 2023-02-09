@push('js')
<script>
    const listTable = @json($tables);
    function loadTableColumns(table_name) {
        return fetch( "{{route('admin.cms-moduls.load-columns', ':table_name')}}".replace(':table_name', table_name), {
            method: "GET",
        })
    }
</script>
<script src="{{asset('adminportal/js/module-builder.js?'.date('YmdHis'))}}"></script>

<style>
    table tr td{
        font-size: 14px;
        font-weight: bold
    }
    table tr th{
        vertical-align: middle
    }
</style>
@endpush

<x-portal::layout.admin page="Application Module Builder" type="List">
    <section class="app-content shadow-sm">
        <form action="{{route('admin.cms-moduls.build-module')}}" method="post" class="formModules">
            @csrf
            <div class="header-form d-flex justify-content-between border-0 mb-1">
                <div class="left-side d-flex align-items-center">
                    <h5 class="form-title">Create your CRUD application moduls</h5>
                </div>
                <div class="right-side d-flex">
                    <a href="{{route("admin.cms-moduls.index")}}" class="btn btn-light text-upper">
                        @lang('adminportal.back_to_list')
                    </a>
                    <button type="button" onclick="next()" class="btn btn-dark btn-next text-upper ms-3">
                        @lang('adminportal.next')
                    </button>
                </div>
            </div>
            <div class="page-inner">
                <ul class="nav nav-tabs" id="moduleGeneratorTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1" role="tab"
                            aria-controls="step1" aria-selected="true">
                            <i class="ms-Icon ms-Icon--Settings"></i>
                            @lang('adminportal.step_1_configuration')
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="step2-tab" data-bs-toggle="tab" onclick="goToStepTwo()"  href="#step2" role="tab"
                            aria-controls="step2" aria-selected="false">
                            <i class="ms-Icon ms-Icon--TableComputed"></i>
                            @lang('adminportal.step_2_table_view')
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="step3-tab" data-bs-toggle="tab" onclick="goToStepThree()" href="#step3" role="tab"
                            aria-controls="step3" aria-selected="false">
                            <i class="ms-Icon ms-Icon--FabricFormLibrary"></i>
                            @lang('adminportal.step_3_form_view')
                        </a>
                    </li>
                </ul>
                <div class="full-height">
                    <div class="tab-content" id="moduleGeneratorTabsContent">
                        <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                            @include('portalmodule::app-module.builder.step1')
                        </div>
                        <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                            @include('portalmodule::app-module.builder.step2')
                        </div>
                        <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                            @include('portalmodule::app-module.builder.step3')
                        </div>
                    </div>
                </div>
        </form>
    </section>

    <x-portal::input.select.asset />
</x-portal::layout.admin>