<x-portal::layout.blank title="{{ __('adminportal.auth.verification.title') }}">
    <div class="container grid h-svh flex-col items-center justify-center lg:max-w-none lg:px-0 bg-background">
        <div class="mx-auto flex w-full flex-col justify-center space-y-2 sm:!w-[500px] lg:p-8 py-5">
            <div class="text-card-foreground shaxdow sm:p-6">
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ __('adminportal.auth.verification.title') }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ __('adminportal.auth.verification.description') }}
                    </p>
                </div>

                <div class="grid gap-6 mt-3">
                    <x-portal::form action="{{ route('admin.verification.update') }}" method="POST"
                        id="form-resend-link">
                        @csrf
                        <x-portal::button x-bind:loading="submited" type="submit" class="w-full">
                            {{ __('adminportal.label.resend_verification_email') }}
                        </x-portal::button>
                    </x-portal::form>
                </div>

                @if (portal('authentication.register.enable'))
                    <x-portal::form action="{{ route('admin.auth.logout') }}" method="POST"
                        class="mt-1 px-8 text-center text-sm text-muted-foreground">
                        @csrf
                        {{ __('adminportal.label.login_with_another_acount') }}
                        <x-portal::button variant="link" type="submit"
                            class="!text-sm !text-muted-foreground underline !px-0 !py-0">
                            {{ __('adminportal.label.logout') }}
                        </x-portal::button>
                    </x-portal::form>
                @endif


            </div>
        </div>
    </div>
    @push('scripts')
        @if ($error = session('error'))
            <script>
                window.addEventListener("load", (event) => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            title: 'Oops! Something went wrong.',
                            message: '{{ $error }}',
                            variant: 'danger',
                            action: {
                                label: 'Send Again',
                                do: () => {
                                    document.getElementById('form-resend-link').submit()
                                }
                            }
                        }
                    }))
                })
            </script>
        @endif
    @endpush
</x-portal::layout.blank>
