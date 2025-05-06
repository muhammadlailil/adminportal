<x-admin :route="$route">
    <x-slot:button-action>
        @if (@$actions['import'] && admin()?->can('create', $policy))
            <div>
                <x-portal::button variant="outline" type="button" x-on:click="dialog='import-data'">
                    {{ __('adminportal.import') }}
                    <x-tabler-upload class="h-4.5" />
                </x-portal::button>
                <x-portal::dialog id="import-data" dismissible>
                    <x-portal::form action="{{ @$route['import'] }}" method="POST" enctype="multipart/form-data" class="!space-y-0">
                        @csrf
                        <x-portal::dialog.header>
                            <x-portal::dialog.title>
                                {{ __('adminportal.import') }} {{ @$pageTitle }}
                            </x-portal::dialog.title>
                            <x-portal::dialog.description>
                                Import {{ @$pageTitle }} quickly from a {{ @$import['format'] }} file.
                            </x-portal::dialog.description>
                        </x-portal::dialog.header>
                        <x-portal::dialog.content>
                            <x-portal::form.input name="file" label="File" type="file" required
                                accept="{{ @$import['accepted'] }}" x-ref="fileImport" />
                            <x-portal::form.description class="mt-2">
                                Click <a href="{{ @$import['sample'] }}" class="underline text-blue-700"
                                    download>here</a> to download sample data format
                            </x-portal::form.description>
                        </x-portal::dialog.content>
                        <x-portal::dialog.footer>
                            <x-portal::button variant="outline" type="button" x-on:click="dialog='';$refs.fileImport.value=''">
                                {{ __('adminportal.cancel') }}
                            </x-portal::button>
                            <x-portal::button type="submit" x-bind:loading="submitted">
                                {{ __('adminportal.import') }}
                            </x-portal::button>
                        </x-portal::dialog.footer>
                    </x-portal::form>
                </x-portal::dialog>
            </div>
        @endif
        @if (count(@$actions['export']))
            <x-portal::dropdown-menu>
                <x-portal::dropdown-menu.trigger variant="outline">
                    {{ __('adminportal.export') }}
                    <x-tabler-download class="h-4.5" />
                </x-portal::dropdown-menu.trigger>
                <x-portal::dropdown-menu.content class="min-w-40" align="end" side="bottom">
                    @foreach (@$actions['export'] as $export)
                        <form action="{{ @$route['export'] }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="{{ $export['key'] }}">
                            {!! input_hidden_query() !!}
                            <x-portal::dropdown-menu.item as="button" type="submit" dismissible>
                                <span>
                                    @svg("tabler-{$export['icon']}", [
                                        'class' => 'h-4.5',
                                    ])
                                </span>
                                {{ $export['label'] }}
                            </x-portal::dropdown-menu.item>
                        </form>
                    @endforeach
                </x-portal::dropdown-menu.content>
            </x-portal::dropdown-menu>
        @endif
        @if (admin()?->can('create', $policy))
            @if (@$actions['create'])
                @if ($actions['popup_form'])
                    <div>
                        <x-portal::button type="button" x-on:click="openCreateCrudForm">
                            {{ __('adminportal.create') }}
                            <x-tabler-plus class="h-4.5" />
                        </x-portal::button>
                        <x-portal::default.crud-form>
                            @include($view['form'])
                        </x-portal::default.crud-form>
                    </div>
                @else
                    <x-portal::button href="{{ route_from_current('create') }}">
                        {{ __('adminportal.create') }}
                        <x-tabler-plus class="h-4.5" />
                    </x-portal::button>
                @endif
            @endif
        @endif
    </x-slot:button-action>
    <x-portal::default.table :actions="$actions" :columns="$columns" :result="$result">
        @include($view['table'])
        <x-slot:action>
            @yield('action')
        </x-slot:action>
        <x-slot:filter-form>
            @yield('filter-form')
        </x-slot:filter-form>
    </x-portal::default.table>

    @if (@$actions['delete'])
        {{-- delete data confirmation --}}
        <x-portal::alert-dialog id="delete-confirmation">
            <x-portal::alert-dialog.content id="delete-confirmation-form" method="POST">
                @csrf
                @method('DELETE')
                <x-portal::alert-dialog.title>
                    {{ __('adminportal.alert.confirmation.delete_title') }}
                </x-portal::alert-dialog.title>
                <x-portal::alert-dialog.description class="mb-5">
                    {{ __('adminportal.alert.confirmation.delete_description') }}
                </x-portal::alert-dialog.description>

                <x-portal::alert-dialog.action>
                    <x-portal::alert-dialog.cancel>
                        {{__('adminportal.cancel')}}
                    </x-portal::alert-dialog.cancel>
                    <x-portal::alert-dialog.confirm variant="danger">
                        {{__('adminportal.continue')}}
                    </x-portal::alert-dialog.confirm>
                </x-portal::alert-dialog.action>

            </x-portal::alert-dialog.content>
        </x-portal::alert-dialog>
    @endif

    @if (@$actions['bulkAction'])
        {{-- bulk action confirmation --}}
        <x-portal::alert-dialog id="bulk-action-confirmation">
            <x-portal::alert-dialog.content action="{{ $route['bulk_actions'] }}" method="POST">
                @csrf
                <x-portal::alert-dialog.title></x-portal::alert-dialog.title>
                <x-portal::alert-dialog.description class="mb-5"></x-portal::alert-dialog.description>

                <x-portal::alert-dialog.action>
                    <x-portal::alert-dialog.cancel>
                        {{__('adminportal.cancel')}}
                    </x-portal::alert-dialog.cancel>
                    <x-portal::alert-dialog.confirm>
                        {{__('adminportal.continue')}}
                    </x-portal::alert-dialog.confirm>
                </x-portal::alert-dialog.action>

            </x-portal::alert-dialog.content>
        </x-portal::alert-dialog>
    @endif
    @yield('html')
</x-admin>
