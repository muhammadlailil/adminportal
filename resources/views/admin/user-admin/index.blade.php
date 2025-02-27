@foreach ($result as $row)
    <x-portal::table.row>
        <x-portal::table.cell class="w-[20px] !pr-2">
            <x-portal::table.checkbox value="{{ $row->id }}" />
        </x-portal::table.cell>
        <x-portal::table.cell>
            {{ $row->name }}
        </x-portal::table.cell>
        <x-portal::table.cell>
            {{ $row->email }}
        </x-portal::table.cell>
        <x-portal::table.cell>
            {{ $row->permission_name }}
        </x-portal::table.cell>
        <x-portal::table.cell>
            {!! $row->status->badge() !!}
        </x-portal::table.cell>
        <x-portal::table.cell class="font-medium text-right !py-2">
            <x-portal::dropdown-menu class="flex justify-end">
                <x-portal::dropdown-menu.trigger variant="ghost" class="h-fit !px-1 !py-1">
                    <x-tabler-dots class="h-4.5" />
                </x-portal::dropdown-menu.trigger>
                <x-portal::dropdown-menu.content class="w-fit" align="end">
                    <x-portal::dropdown-menu.item
                        x-on:click="toggleEditForm({{ json_encode($row->only(['uuid', 'name', 'email', 'role_permission_id', 'status'])) }})">
                        Edit
                    </x-portal::dropdown-menu.item>
                    <x-portal::dropdown-menu.item variant="danger" x-data-delete-confirmation="{{ $row->uuid }}"
                        dismissible class="text-red-600">
                        Delete
                    </x-portal::dropdown-menu.item>
                </x-portal::dropdown-menu.content>
            </x-portal::dropdown-menu>
        </x-portal::table.cell>
    </x-portal::table.row>
@endforeach

@section('filter-form')
    <div class="grid w-full max-w-sm items-center gap-1.5">
        <x-portal::label htmlFor="role">Role Permission</x-portal::label>
        <div class="flex flex-col items-start space-x-3">
            @foreach ($permissions as $permission)
                <x-portal::checkbox id="{{ $permission->id }}" label="{{ $permission->name }}" value="{{ $permission->id }}"
                    name="filter[permission_id][]" :checked="in_array($permission->id, @request('filter')['permission_id'] ?: [])" />
            @endforeach
        </div>
    </div>
@endsection

@section('html')
    <x-portal::alert-dialog id="update-status">
        <x-portal::alert-dialog.content action="{{ $route['bulk_actions'] }}" method="POST">
            @csrf
            <x-portal::alert-dialog.title></x-portal::alert-dialog.title>
            <x-portal::form.group label="Status" name="status">
                <div class="flex gap-1 flex-col">
                    <x-portal::radio id="bulk_status_active" value="1" name="status" label="Active" required
                        :checked="old('status') == '1'" />
                    <x-portal::radio id="bulk_status_in_active" value="0" name="status" label="In Active" required
                        :checked="old('status') == '0'" />
                </div>
            </x-portal::form.group>

            <x-portal::alert-dialog.action>
                <x-portal::alert-dialog.cancel>Cancel</x-portal::alert-dialog.cancel>
                <x-portal::alert-dialog.confirm>Continue</x-portal::alert-dialog.confirm>
            </x-portal::alert-dialog.action>

        </x-portal::alert-dialog.content>
    </x-portal::alert-dialog>
@endsection
