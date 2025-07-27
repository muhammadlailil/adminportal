<x-portal::input.select name="table" label="Table" horizontal class="searchable">
    @foreach ($tables as $table)
    <option value="{{$table->name}}">{{$table->name}}</option>
    @endforeach
</x-portal::input.select>
<x-portal::input type="text" name="module_name" label="Module Name" placeholder="Module name ..." horizontal>
</x-portal::input>
<x-portal::input type="text" name="module_path" label="Module Path" placeholder="Module path ..." horizontal>
</x-portal::input>
<x-portal::input type="text" name="module_controller" label="Controller Name" placeholder="AdminUserController"
    horizontal>
</x-portal::input>

<x-portal::input.select name="module_icon" label="Module Icon" class="searchable select-icons" horizontal>
    @foreach ($icons as $icon)
    <option value="{{$icon}}">{{$icon}}</option>
    @endforeach
</x-portal::input.select>
<x-portal::input.checkbox name="action" label="Configuration" horizontal>
    <x-portal::input.checkbox.option required="false" class="me-5" checked name="bulk_action" label="Bulk Action?" value="1"></x-portal::input.checkbox.option>
    <x-portal::input.checkbox.option required="false" class="me-5" checked name="has_create" label="Create?" value="1"></x-portal::input.checkbox.option>
    <x-portal::input.checkbox.option required="false" class="me-5" checked name="has_edit" label="Edit?" value="1"></x-portal::input.checkbox.option>
    <x-portal::input.checkbox.option required="false" class="me-5" checked name="has_delete" label="Delete?" value="1"></x-portal::input.checkbox.option>
    <x-portal::input.checkbox.option required="false" class="me-5" name="has_filter" label="Filter?" value="1"></x-portal::input.checkbox.option>
    <x-portal::input.checkbox.option required="false" class="me-5" name="has_import" label="Import?" value="1"></x-portal::input.checkbox.option>
    <x-portal::input.checkbox.option required="false" class="me-5" name="has_export" label="Export?" value="1"></x-portal::input.checkbox.option>
</x-portal::input.checkbox>