<div class="mt-3 space-y-4" x-data="{
    selectedTableID: [],
    toggleSelectAll($el) {
        const _self = this
        document.querySelectorAll('.checkbox-table').forEach((element) => {
            if ($el.target.checked) {
                if (_self.selectedTableID.indexOf(element.value) === -1) {
                    _self.selectedTableID.push(element.value)
                }
                element.closest('tr').setAttribute('data-state', 'selected')
            } else {
                _self.selectedTableID = []
                element.closest('tr').removeAttribute('data-state')
            }
        })
    },
    selectCheckboxTable($el) {
        if ($el.target.checked) {
            $el.target.closest('tr').setAttribute('data-state', 'selected')
        } else {
            $el.target.closest('tr').removeAttribute('data-state')
        }
    }
}">
    <div class="flex items-center justify-between flex-col md:flex-row gap-2">
        <div class="flex space-x-2 w-full">
            <form action="{{ request()->url() }}" method="get" class="md:w-fit w-full">
                {!! input_hidden_query(['search']) !!}
                <x-portal::input type="text" placeholder="Search {{@$pageTitle}} ..." name="search" class="w-[150px] lg:w-[300px]"
                    value="{{ strip_tags(request('search') ?? '') }}" />
            </form>
            @if (@$actions['filter'])
                <x-portal::popover>
                    <x-portal::popover.trigger>
                        <x-portal::button variant="outline">
                            {{ __('adminportal.filter') }}
                            <x-tabler-filter class="h-4.5" />
                        </x-portal::button>
                    </x-portal::popover.trigger>
                    <x-portal::popover.content class="min-w-[20rem] !p-0" align="start" side="bottom">
                        <form action="{{ request()->url() }}" method="get">
                            {!! input_hidden_query(['filter']) !!}
                            <div class="space-y-2 p-5">
                                <x-portal::dialog.title>Filter</x-portal::dialog.title>
                            </div>
                            <div class="grid gap-2 px-5 py-1 max-h-[400px] overflow-auto">
                                {{ @$filterForm }}
                            </div>
                            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 p-5">
                                <x-portal::button size="sm" variant="outline" href="{{ request()->url() }}">
                                    {{ __('adminportal.reset') }}
                                </x-portal::button>
                                <x-portal::button size="sm" type="submit">
                                    {{ __('adminportal.apply') }}
                                </x-portal::button>
                            </div>
                        </form>
                    </x-portal::popover.content>
                </x-portal::popover>
            @endif
            @if (request('filter') || request('search'))
                <x-portal::button variant="ghost" href="{{ request()->url() }}">
                    {{ __('adminportal.reset') }}
                    <x-tabler-x class="h-4.5" />
                </x-portal::button>
            @endif
        </div>
        <div class="flex space-x-2 w-full gap-2 md:justify-end justify-start">
            {{ @$action }}
            @if (@$actions['bulkAction'])
                <x-portal::dropdown-menu x-show="selectedTableID.length" x-cloak>
                    <x-portal::dropdown-menu.trigger variant="outline">
                        {{ __('adminportal.bulk_actions') }}
                        <x-tabler-dots-vertical class="h-4.5" />
                    </x-portal::dropdown-menu.trigger>
                    <x-portal::dropdown-menu.content class="!min-w-52" align="end" side="bottom">
                        <x-portal::dropdown-menu.label class="bg-accent">
                            <span x-html="`${selectedTableID.length} Selected`"></span>
                        </x-portal::dropdown-menu.label>
                        @foreach ($actions['bulk_actions'] as $bulk)
                            <x-portal::dropdown-menu.item data-action="{{ $bulk['key'] }}"
                                data-label="{{ $bulk['label'] }}" data-dialog="{{ $bulk['dialog'] }}"
                                x-bind:data-selected="selectedTableID"
                                data-variant="{{ $bulk['variant'] }}"
                                variant="{{ $bulk['variant'] }}" x-data-bulk-action-confirmation dismissible
                                class="{{ $bulk['variant'] == 'danger' ? 'text-red-600' : '' }}">
                                @svg("tabler-{$bulk['icon']}", [
                                    'class' => 'h-4.5',
                                ])
                                {{ $bulk['label'] }}
                            </x-portal::dropdown-menu.item>
                        @endforeach
                    </x-portal::dropdown-menu.content>
                </x-portal::dropdown-menu>
            @endif
        </div>
    </div>
    <x-portal::table>
        <thead>
            <x-portal::table.row class="!text-neutral-800">
                @if (@$actions['bulkAction'])
                    <x-portal::table.head class="w-[20px] !pr-2">
                        <x-portal::checkbox x-on:click="toggleSelectAll" />
                    </x-portal::table.head>
                @endif
                @if (@$actions['in_left'])
                    <x-portal::table.head>Action</x-portal::table.head>
                @endif
                @foreach ($columns as $column)
                    <x-portal::table.head sortable="{{ $column['sorting'] }}" key="{{ $column['name'] }}">
                        {{ $column['label'] }}
                    </x-portal::table.head>
                @endforeach
                @if (!@$actions['in_left'])
                    <x-portal::table.head class="[&>*]:justify-end">
                        {{ __('adminportal.action') }}
                    </x-portal::table.head>
                @endif
            </x-portal::table.row>
        </thead>
        <tbody class="divide-y divide-border">
            {{ $slot }}
        </tbody>
    </x-portal::table>
    <div class="flex items-center justify-between">
        <div class="flex space-x-2 items-center">
            <x-portal::pagination.limit limit="{{ request()->limit ?: '10' }}" />
            <div class="hidden flex-1 text-sm text-muted-foreground sm:block">
                @php
                    $from = $result->count() ? $result->perPage() * $result->currentPage() - $result->perPage() + 1 : 0;
                    $to = $result->perPage() * $result->currentPage() - $result->perPage() + $result->count();
                @endphp
                Showing {{ $from }} to {{ $to }} of {{ number_format($result->total()) }}
            </div>
        </div>
        <div class="flex space-x-2">
            <x-portal::pagination :paginator="$result" />
        </div>
    </div>
</div>
