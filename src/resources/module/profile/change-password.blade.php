<div class="col-sm-7">
    <section class="app-content shadow-sm">
        <form action="{{route('admin.change-password')}}" method="post">
            @csrf
            <h5 class="page-title-card mb-4">@lang('adminportal.change_password')</h5>
            <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                <i class="isax-b icon-info-circle icon"></i>
                @lang('adminportal.password_validation_message')
            </div>

            <x-portal::input.password name="old_password" label="{{__('adminportal.old_password')}}"
                placeholder="{{__('adminportal.old_password')}}"></x-portal::input.password>
            <x-portal::input.password name="password" label="{{__('adminportal.new_password')}}"
                placeholder="{{__('adminportal.new_password')}}"></x-portal::input.password>
            <x-portal::input.password name="password_confirmation" label="{{__('adminportal.confirm_new_password')}}"
                placeholder="{{__('adminportal.confirm_new_password')}}"></x-portal::input.password>

            <button type="submit" class="btn btn-dark w-100 btn-block justify-content-center text-upper mb-3 mt-5">
                @lang('adminportal.save')
            </button>
            <a href="{{route('admin.profile')}}"
                class="btn btn-light w-100 btn-block justify-content-center text-upper">@lang('adminportal.back')</a>
        </form>
    </section>
</div>