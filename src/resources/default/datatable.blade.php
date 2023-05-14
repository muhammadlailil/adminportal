<x-portal::layout.admin :page="$page_title" type="List">
    <section class="app-content shadow-sm">
        <x-portal::table.datatable :columns="$table_columns" :button="$button" :result="$data" :route="$route">
            @include($datatable_views)
        </x-portal::table.datatable>
    </section>

    @if (@$button['export'])
        <x-portal::popup.export-data>
            <x-slot name="title">Export {{ $page_title }}</x-slot>
            <x-slot name="action">{{ route("{$route}.export") }}</x-slot>
        </x-portal::popup.export-data>
        <x-portal::input.select.asset />
    @endif
    @if (@$button['import'])
        <x-portal::popup.import-data>
            <x-slot name="title">Import {{ $page_title }}</x-slot>
            <x-slot name="action">{{ route("{$route}.import") }}</x-slot>
            <x-slot name="sample_file">{{ url('import-excel/sample-import-' . str()->slug($page_title) . '.xlsx') }}
            </x-slot>
        </x-portal::popup.import-data>
    @endif


    @stack('html')
</x-portal::layout.admin>
