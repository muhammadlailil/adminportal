<x-portal::dialog id="crud-form" size="lg">
    <form x-data="{ submited: false }" x-ref="crudFormElement" id="crudFormElement" x-on:submit="submited=true" method="POST" enctype="multipart/form-data">
        @csrf
        <x-portal::dialog.header>
            <x-portal::dialog.title>
                <span x-html="crudForm.title"></span>
            </x-portal::dialog.title>
            <x-portal::dialog.description>
                <span x-html="crudForm.description"></span>
            </x-portal::dialog.description>
        </x-portal::dialog.header>
        <x-portal::dialog.content class="space-y-5">

            {{ $slot }}

        </x-portal::dialog.content>
        <x-portal::dialog.footer>
            <x-portal::button variant="outline" type="button" x-on:click="toggleDialog('crud-form')">
                {{ __('adminportal.cancel') }}
            </x-portal::button>
            <x-portal::button type="submit" x-bind:loading="submited">
                {{ __('adminportal.save') }}
            </x-portal::button>
        </x-portal::dialog.footer>
    </form>
</x-portal::dialog>
