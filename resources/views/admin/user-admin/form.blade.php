<x-portal::form.input type="text" name="name" label="{{ __('adminportal.form.name') }}" required
    placeholder="John Doe" value="{{ old('name') }}" />

<x-portal::form.input type="email" name="email" label="{{ __('adminportal.form.email') }}" required
    placeholder="name@example.com" value="{{ old('email') }}" />

<x-portal::form.input type="password" name="password" label="{{ __('adminportal.form.password') }}"
    placeholder="********" viewable required />

<x-portal::form.combobox name="role_permission_id" label="Permission" placeholder="Select Permission" required>
    @foreach ($permissions as $permission)
        <x-portal::combobox.option :selected="old('role_permission_id')==$permission->id" value="{{ $permission->id }}">
            {{ $permission->name }}
        </x-portal::combobox.option>
    @endforeach
</x-portal::form.combobox>

<x-portal::form.group label="Status" name="status">
    <div class="flex gap-1 flex-col">
        <x-portal::radio id="status_active" value="1" name="status" label="Active" required :checked="old('status')=='1'"/>
        <x-portal::radio id="status_in_active" value="0" name="status" label="In Active" required :checked="old('status')=='0'"/>
    </div>
</x-portal::form.group>
