<div class="form-group {{(@$horizontal)?'row':''}} {{($errors->has($name))?'has-error':''}}">
    <label for="" class="label {{(@$horizontal)?'col-sm-2':'text-bold'}}">
        {{$label}}
        @if(!@$required)
        <span class="required">*</span>
        @endif
    </label>
    @if(@$horizontal)
    <div class="col-sm-6">
        <div class="input-icon input-password">
            <input type="password" name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}"
                {{(@$required)?'':'required'}} placeholder="{{@$placeholder}}">
            <i class="isax icon-eye icon"></i>
        </div>
        @if($errors->has($name))
        <span class="error-text">{{$errors->first($name)}}</span>
        @endif
        @if($slot)
        <span class="help-text">@lang('adminportal.update_password_help_text')</span>
        @endif
    </div>
    @else
    <div class="input-icon input-password">
        <input type="password" name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}"
            {{(@$required)?'':'required'}} placeholder="{{@$placeholder}}">
        <i class="isax icon-eye icon"></i>
    </div>
    @if($errors->has($name))
    <span class="error-text">{{$errors->first($name)}}</span>
    @endif
    @if($slot!='')
    <span class="help-text">@lang('adminportal.update_password_help_text')</span>
    @endif
    @endif
</div>