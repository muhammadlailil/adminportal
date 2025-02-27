<x-portal::layout.admin>
    <x-portal::separator class="my-5" />
    <x-portal::form action="{{ $action['route'] }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method($action['method'])
        @include($view)
    </x-portal::form>
</x-portal::layout.admin>
