@foreach ($result as $row)
    <x-portal::table.row>
        <x-portal::table.cell class="w-[20px] !pr-2">
            <x-portal::table.checkbox value="{{ $row->id }}" />
        </x-portal::table.cell>
        <x-portal::table.cell>
            {{ $row->name }}
        </x-portal::table.cell>
        <x-portal::table.cell>
            {{ $row->alias }}
        </x-portal::table.cell>
        <x-portal::table.cell>
            {!! $row->badge_superadmin !!}
        </x-portal::table.cell>
        <x-portal::table.cell class="font-medium text-right !py-2">
            <x-portal::dropdown-menu class="flex justify-end">
                <x-portal::dropdown-menu.trigger variant="ghost" class="h-fit !px-1 !py-1">
                    <x-tabler-dots class="h-4.5" />
                </x-portal::dropdown-menu.trigger>
                <x-portal::dropdown-menu.content class="w-fit" align="end">
                    <x-portal::dropdown-menu.item as="a" href="{{ route_from_current('edit',$row->uuid) }}">
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
