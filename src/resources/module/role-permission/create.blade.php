@push('js')
<script>
document.querySelector('.btn-select-all').addEventListener('click',function(){
    document.querySelectorAll('#list-module-permission .form-checkbox  input[type="checkbox"]').forEach((item)=>{
        item.checked = true
    })
})
document.querySelector('.btn-unselect').addEventListener('click',function(){
    document.querySelectorAll('#list-module-permission .form-checkbox  input[type="checkbox"]').forEach((item)=>{
        item.checked = false
    })
})
</script>
@endpush
<x-portal::input type="text" name="name" label="Nama" placeholder="Finance" horizontal>
    {{old('name')}}
</x-portal::input>
<x-portal::input.radio.group name="is_superadmin" label="Superadmin" horizontal>
    <x-portal::input.radio.group.option class="me-4" name="is_superadmin" label="Yes" value="1">
    </x-portal::input.radio.group.option>
    <x-portal::input.radio.group.option checked name="is_superadmin" label="No" value="0"></x-portal::input.radio.group.option>
</x-portal::input.radio.group>
<div class="form-group row" style="align-items: baseline;">
    <label for="" class="label col-sm-2">
        Permissions
        <span class="required">*</span>
    </label>
    <div class="col-sm-6 ">
        <div class="d-flex mb-3">
            <button type="button" class="btn btn-light btn-select-all btn-sm me-3">SELECT ALL</button>
            <button type="button" class="btn btn-light btn-unselect btn-sm">UN SELECT ALL</button>
        </div>
        <div class="row" id="list-module-permission">
            @php
            $listed = array_chunk($moduls, ceil(count($moduls) / 2));
            $left = @$listed[0] ?? [];
            $right = @$listed[1] ?? [];
            @endphp
            <div class="col-sm-6">
                <ul class="list-permission list-group ps-0">
                    @foreach ($left as $row)
                    @php
                    $pathLeft = explode('/',$row->path);
                    $pathLeft = $pathLeft[count($pathLeft)-1];
                    @endphp
                    <li class="list-group-item p-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 fw-bold">{{$row->name}}</h6>
                        </div>
                    <li class="list-group-item ps-0 pt-1">
                        <ul class="p-0">
                            <li class="list-group-item p-2 ps-0">
                                <x-portal::input.checkbox.option required="false" name="permissions[][{{$row->id}}]"
                                    value="add admin.{{str()->slug($pathLeft)}}"
                                    label="add {{str()->slug($pathLeft,' ')}}"></x-portal::input.checkbox.option>
                            </li>
                            <li class="list-group-item p-2 ps-0">
                                <x-portal::input.checkbox.option required="false" name="permissions[][{{$row->id}}]"
                                    value="view admin.{{str()->slug($pathLeft)}}"
                                    label="view {{str()->slug($pathLeft,' ')}}"></x-portal::input.checkbox.option>
                            </li>
                            <li class="list-group-item p-2 ps-0">
                                <x-portal::input.checkbox.option required="false" name="permissions[][{{$row->id}}]"
                                    value="edit admin.{{str()->slug($pathLeft)}}"
                                    label="edit {{str()->slug($pathLeft,' ')}}"></x-portal::input.checkbox.option>
                            </li>
                            <li class="list-group-item p-2 ps-0">
                                <x-portal::input.checkbox.option required="false" name="permissions[][{{$row->id}}]"
                                    value="delete admin.{{str()->slug($pathLeft)}}"
                                    label="delete {{str()->slug($pathLeft,' ')}}"></x-portal::input.checkbox.option>
                            </li>
                        </ul>
                    </li>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6">
                <ul class="list-permission list-group ps-0">
                    @foreach ($right as $key)
                    @php
                    $pathRight = explode('/',$key->path);
                    $pathRight = $pathRight[count($pathRight)-1];
                    @endphp
                    <li class="list-group-item p-0">
                        <h6 class="mb-0 fw-bold">{{$key->name}}</h6>
                        <li class="list-group-item ps-0 pt-1">
                            <ul class="p-0">
                                <li class="list-group-item p-2 ps-0">
                                    <x-portal::input.checkbox.option required="false" name="permissions[][$key->id]"
                                        value="add admin.{{str()->slug($pathRight)}}"
                                        label="add {{str()->slug($pathRight,' ')}}"></x-portal::input.checkbox.option>
                                </li>
                                <li class="list-group-item p-2 ps-0">
                                    <x-portal::input.checkbox.option required="false" name="permissions[][$key->id]"
                                        value="view admin.{{str()->slug($pathRight)}}"
                                        label="view {{str()->slug($pathRight,' ')}}"></x-portal::input.checkbox.option>
                                </li>
                                <li class="list-group-item p-2 ps-0">
                                    <x-portal::input.checkbox.option required="false" name="permissions[][$key->id]"
                                        value="edit admin.{{str()->slug($pathRight)}}"
                                        label="edit {{str()->slug($pathRight,' ')}}"></x-portal::input.checkbox.option>
                                </li>
                                <li class="list-group-item p-2 ps-0">
                                    <x-portal::input.checkbox.option required="false" name="permissions[][$key->id]"
                                        value="delete admin.{{str()->slug($pathRight)}}"
                                        label="delete {{str()->slug($pathRight,' ')}}"></x-portal::input.checkbox.option>
                                </li>
                            </ul>
                        </li>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>