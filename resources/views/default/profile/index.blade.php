<x-admin>
    <x-portal::separator class="my-5" />
    <div class="flex flex-1 flex-col space-y-2 overflow-hidden md:space-y-2 lg:flex-row lg:space-x-12 lg:space-y-0"
        x-data="{
            active: '{{session('active') ?: 'profile'}}',
        }">
        <aside class="top-0 lg:sticky lg:w-1/5">
            <ul class="flex flex-col gap-2">
                <li>
                    <x-portal::button variant="link" x-on:click="active='profile'" class="w-full justify-start"
                        x-bind:class="{
                            'bg-secondary !no-underline': active=='profile'
                        }">
                        <x-tabler-user class="h-4.5" />
                        Profile
                    </x-portal::button>
                </li>
                <li>
                    <x-portal::button variant="link" x-on:click="active='password'" class="w-full justify-start"
                        x-bind:class="{
                            'bg-secondary !no-underline': active=='password'
                        }">
                        <x-tabler-lock class="h-4.5" />
                        Password
                    </x-portal::button>
                </li>
            </ul>
        </aside>
        <div class="flex w-full overflow-y-hidden p-1 pr-4">
            <div class="flex flex-1 flex-col" x-show="active=='profile'" x-cloak>
                <div class="flex-none">
                    <h3 class="text-lg font-medium">Profile</h3>
                    <p class="text-sm text-muted-foreground">Update your name and email address.</p>
                    <x-portal::separator class="mt-3 mb-4" />
                    <x-portal::form action="{{ route('admin.profile.update') }}" method="POST"
                        enctype="multipart/form-data" class="lg:max-w-xl">
                        @csrf
                        <x-portal::form.input name="name" label="{{ __('adminportal.form.name') }}"
                            placeholder="shadcn" type="text" value="{{ admin()->name }}" />
                        <x-portal::form.input name="email" label="{{ __('adminportal.form.email') }}"
                            placeholder="name@example.com" value="{{ admin()->email }}" type="email" />
                        <x-portal::button x-bind:loading="submitted" type="submit">
                            {{ __('adminportal.save') }}
                        </x-portal::button>
                    </x-portal::form>
                </div>
            </div>
            <div class="flex flex-1 flex-col" x-show="active=='password'" x-cloak>
                <div class="flex-none">
                    <h3 class="text-lg font-medium">Password</h3>
                    <p class="text-sm text-muted-foreground">Update your current password.</p>
                    <x-portal::separator class="mt-3 mb-4" />
                    <x-portal::form action="{{ route('admin.profile.update-password') }}" method="POST" enctype="multipart/form-data" class="lg:max-w-xl">
                        @csrf
                        <x-portal::form.input type="password" name="current_password"
                            label="{{ __('adminportal.form.current_password') }}" placeholder="********" viewable
                            required />

                        <x-portal::form.input type="password" name="password"
                            label="{{ __('adminportal.form.new_password') }}" placeholder="********" viewable
                            required />

                        <x-portal::form.input type="password" name="password_confirmation"
                            label="{{ __('adminportal.form.password_confirmation') }}" placeholder="********" viewable
                            required />

                        <x-portal::button x-bind:loading="submitted" type="submit">
                            {{ __('adminportal.save') }}
                        </x-portal::button>
                    </x-portal::form>
                </div>
            </div>
        </div>
    </div>
</x-admin>
