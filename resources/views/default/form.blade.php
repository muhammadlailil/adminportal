<x-admin>
    <x-portal::separator class="my-5" />
    <x-portal::form action="{{ $action['route'] }}" method="POST" enctype="multipart/form-data" id="crud-default-form">
        @csrf
        @method($action['method'])
        @include($view)
    </x-portal::form>
</x-admin>
