<x-portal::input.image label="Profile" name="profile" horizontal></x-portal::input.image>
<x-portal::input type="text" name="name" label="Nama" placeholder="Jhon Doe" horizontal>
    {{old('name')}}
</x-portal::input>
<x-portal::input type="email" name="email" label="Email" placeholder="jhon@doe.com" horizontal>
    {{old('email')}}
</x-portal::input>
<x-portal::input.select name="role_permission_id" label="Role" horizontal>
    @foreach ($roles as $role)
        <option value="{{$role->id}}">{{$role->name}}</option>
    @endforeach
</x-portal::input.select>
<x-portal::input.radio name="status" label="Status" horizontal>
    <x-portal::input.radio.option class="me-4" name="status" label="Active" value="1"></x-portal::input.radio.option>
    <x-portal::input.radio.option name="status" label="Non Active" value="0"></x-portal::input.radio.option>
</x-portal::input.radio>
<x-portal::input.password  name="password" label="Password" placeholder="Password" horizontal></x-portal::input.password>

<x-portal::input.select.asset/>