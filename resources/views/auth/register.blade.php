<x-portal::layout.blank title="{{ __('adminportal.auth.sigup.title') }}">
    <div class="container grid h-svh flex-col items-center justify-center lg:max-w-none lg:px-0 bg-background">
        <div class="mx-auto flex w-full flex-col justify-center space-y-2 sm:!w-[480px] lg:p-8 py-5">
            <div class="mb-4 flex items-center justify-center gap-2">
                <img src="{{ asset(portal('logo')) }}" alt="{{ config('app.name') }}" class="{{ portal('authentication.register.show_appname') ? 'h-8' : 'h-10' }}">
                @if(portal('authentication.register.show_appname'))
                    <h1 class="text-2xl font-semibold">
                        {{ config('app.name') }}
                    </h1>
                @endif
            </div>
            <div class="text-card-foreground shaxdow sm:p-6">
                <div class="flex flex-col space-y-2 text-left">
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ __('adminportal.auth.sigup.title') }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ __('adminportal.auth.login.description') }}
                    </p>
                </div>
                <div class="grid gap-6 mt-3">
                    <x-portal::form action="{{ route('admin.auth.register.attempt') }}" method="POST">
                        @csrf
                        <x-portal::form.input type="text" name="name"
                            label="{{ __('adminportal.form.name') }}" required placeholder="John Doe"
                            value="{{ old('name') }}" />

                        <x-portal::form.input type="email" name="email" label="{{ __('adminportal.form.email') }}"
                            required placeholder="name@example.com" value="{{ old('email') }}" />

                        <x-portal::form.input type="password" name="password"
                            label="{{ __('adminportal.form.password') }}" placeholder="********" viewable required />

                        <x-portal::form.input type="password" name="password_confirmation"
                            label="{{ __('adminportal.form.password_confirmation') }}" placeholder="********" viewable
                            required />

                        <x-portal::button x-bind:loading="submitted" type="submit" class="w-full">
                            {{ __('adminportal.auth.sigup.title') }}
                        </x-portal::button>
                    </x-portal::form>
                </div>
                <p class="mt-4 px-8 text-center text-sm text-muted-foreground">
                    {{ __('adminportal.label.have_an_account') }}
                    <x-portal::link href="{{ route(portal('authentication.login.route')) }}"
                        class="text-sm text-muted-foreground">
                        {{ __('adminportal.auth.login.title') }}
                    </x-portal::link>
                </p>

            </div>
        </div>
    </div>
</x-portal::layout.blank>
