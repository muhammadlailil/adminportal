@push('js')
<style>
    input,
    select {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 8px 10px;
        outline: none !important;
        box-shadow: none !important;
        font-weight: normal;
        font-family: "Krub-Medium";
        width: 100%
    }
</style>
<script src="{{asset('adminportal/js/create-mm.js')}}"></script>
@endpush
<x-portal::layout.admin page="Application Module" type="List">
    <div class="row">
        <div class="col-sm-9">
            <section class="app-content shadow-sm pb-2">
                <x-portal::input type="text" name="table_name" label="Table name" horizontal placeholder="user_admin">
                </x-portal::input>
                <div class="table-responsive">
                    <table class="table" id="table-field-table">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Length/Value</th>
                            <th>Default</th>
                            <th>Nullable</th>
                            <th>Index</th>
                            <th></th>
                        </tr>
                        <tbody id="list-field">
                            <tr>
                                <th>
                                    <input type="text">
                                </th>
                                <th>
                                    <select name="" id="">
                                        @foreach($column_type as $type)
                                        <option value="{{$type}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <input type="text" name="" id="">
                                </th>
                                <th>
                                    <input type="text">
                                </th>
                                <th>
                                    <x-portal::input.checkbox.option class="mb-3" name="" label="" value="1">
                                    </x-portal::input.checkbox.option>
                                </th>
                                <th>
                                    <select name="" id="">
                                        <option value="">-----</option>
                                        <option value="unique">unique</option>
                                        <option value="index">index</option>
                                    </select>
                                </th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-danger btn-del-field">DEL</button>
                                </th>
                            </tr>
                        </tbody>
                        <tr>
                            <tr>
                                <th colspan="7">
                                    <button type="button" class="btn btn-sm btn-light" id="add-new-field">Add New Field</button>
                                </th>
                            </tr>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-sm-3">
            <section class="app-content shadow-sm">
                <div class="header-form d-flex justify-content-between">
                    <div>
                        <a href="{{route('admin.cms-moduls.index')}}" class="btn btn-light text-upper">
                            @lang('adminportal.back')
                        </a>
                    </div>
                    <div class="right-side d-flex">
                        <a href="{{route('admin.cms-moduls.builder')}}" class="btn btn-dark text-upper ms-3">
                            @lang('adminportal.save')
                        </a>
                    </div>
                </div>
                <x-portal::input.radio.option class="mb-3" name="id" label="id (uuid)" value="uuid" checked>
                </x-portal::input.radio.option>
                <x-portal::input.radio.option class="mb-3" name="id" label="id (auto_increment)" value="ai">
                </x-portal::input.radio.option>
                <x-portal::input.checkbox.option class="mb-3" name="timestamps"
                    label="timestamps (created_at,updated_at)" value="1" checked></x-portal::input.checkbox.option>
                <x-portal::input.checkbox.option class="mb-3" name="soft deletes" label="soft deletes (deleted_at)"
                    value="1"></x-portal::input.checkbox.option>
            </section>
        </div>
    </div>

    <x-portal::input.select.asset />
</x-portal::layout.admin>