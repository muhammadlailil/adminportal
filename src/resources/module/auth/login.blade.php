<x-portal::layout.blank page="{{ __('adminportal.login') }}">
    <div class="row h-100 m-0 auth-screen">
        <div class="col-sm-6 bg-body-tertiary left-side position-relative d-flex flex-column justify-content-center align-items-center"
            style="background-image: url({{ asset(portal_config('login.banner')) }})">
            <a href="" class="app-logo position-absolute">
                <img src="{{ asset(portal_config('app_icon')) }}" alt="" width="170px">
            </a>
            <div class="text-banner text-white text-center">
                <h1 class="title">{{ portal_config('login.banner_title') }}</h1>
                <p class="description">{{ portal_config('login.banner_description') }}</p>
            </div>
        </div>
        <div class="col-sm-6 right-side d-flex justify-content-center align-items-center bg-light">
            <form action="{{ route('admin.auth.login') }}" method="post" class="content">
                @csrf
                <h5 class="page-title-card mb-5">@lang('adminportal.login')</h5>
                <x-portal::input type="email" label="{{ __('adminportal.email') }}" name="email"
                    placeholder="your@email.com">{{ old('email') }}</x-portal::input>
                <x-portal::input.password label="{{ __('adminportal.password') }}" name="password"
                    placeholder="Password"></x-portal::input.password>
                @if (portal_config('login.forgot_password'))
                    <div class="text-end fs-14" style="margin-top: -10px">
                        <a href="{{ portal_config('login.forgot_password') }}"
                            class="text-decoration-none text-black">@lang('adminportal.forgot_password')</a>
                    </div>
                @endif
                <button type="submit"
                    class="btn btn-dark w-100 btn-block justify-content-center text-upper mb-3 mt-5">@lang('adminportal.login')</button>
                <div class="text-center">
                    <p class="fs-14">@lang('adminportal.dont_have_account_yet')
                        <a href="{{ portal_config('login.forgot_password') }}"
                            class="text-decoration-none text-primary">@lang('adminportal.register')</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-portal::layout.blank>
