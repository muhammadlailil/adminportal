<x-portal::layout.blank title="{{ __('adminportal.auth.forgot_password.title') }}">
    <div class="container grid h-svh flex-col items-center justify-center lg:max-w-none lg:px-0 bg-background">
        <div class="mx-auto flex w-full flex-col justify-center space-y-2 sm:!w-[480px] lg:p-8 py-5">
            <div class="mb-4 flex items-center justify-center gap-2">
                <img src="{{ asset(portal('logo')) }}" alt="{{ config('app.name') }}" class="{{ portal('authentication.forgot_password.show_appname') ? 'h-8' : 'h-10' }}">
                @if(portal('authentication.forgot_password.show_appname'))
                    <h1 class="text-2xl font-semibold">
                        {{ config('app.name') }}
                    </h1>
                @endif
            </div>
            <div class="text-card-foreground shaxdow sm:p-6">
                <div class="flex flex-col space-y-2 text-left">
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ __('adminportal.auth.forgot_password.title') }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ __('adminportal.auth.forgot_password.description') }}
                    </p>
                </div>
                <div class="grid gap-6 mt-3">
                    <x-portal::form action="{{ route('admin.auth.forgot-password.attempt') }}" method="POST">
                        @csrf
                        <x-portal::form.input type="email" name="email" label="{{ __('adminportal.form.email') }}"
                            required placeholder="name@example.com" value="{{ old('email') }}" />

                        <x-portal::button x-bind:loading="submitted" type="submit" class="w-full">
                            {{ __('adminportal.auth.forgot_password.continue') }}
                        </x-portal::button>
                    </x-portal::form>
                </div>
                @if (portal('authentication.register.enable'))
                    <p class="mt-4 px-8 text-center text-sm text-muted-foreground">
                        {{ __('adminportal.label.dont_have_an_account') }}
                        <x-portal::link href="{{ route(portal('authentication.register.route')) }}"
                            class="text-sm text-muted-foreground">
                            {{ __('adminportal.auth.sigup.title') }}
                        </x-portal::link>
                    </p>
                @endif
            </div>
        </div>
    </div>


    @push('scripts')
        @if ($success = session('success'))
            <script>
                window.addEventListener("load", (event) => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            message: '{{ $success }}',
                            position: 'bottom-center'
                        }
                    }))
                })
            </script>
        @endif
    @endpush
</x-portal::layout.blank>
