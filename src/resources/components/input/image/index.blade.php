@php
    if(!@$attributes['required']){
        $attributes['required'] = true;
    }else{
        unset($attributes['required']);
    }
    $required = @$attributes['required'];
@endphp

<div class="form-group {{(@$horizontal)?'row':''}} {{($errors->has($name))?'has-error':''}}">
    <label for="" class="label {{(@$horizontal)?'col-sm-2':'text-bold'}}">
        {{$label}}
        @if(@$required)
        <span class="required">*</span>
        @endif
    </label>
    @if(@$horizontal)
    <div class="col-sm-6">
        <div class="form-image-upload rounded"
            style="background-image: url('{{($slot!='')?asset($slot):'https://ui-avatars.com/api/?name='.config('app.name').'&color=FFF&background='.portalconfig('theme_color').''}}'); background-position: center; background-size: cover;">
            <input type="file" name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}"
                {{$attributes}} accept="image/*">
        </div>
    </div>
    @else
    <div class="form-image-upload rounded"
        style="background-image: url('{{asset(($slot=='')?'adminportal/img/avatar.jpg':$slot)}}');">
        <input type="file" name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}"
            {{$attributes}} accept="image/*">
    </div>
    @endif
    @if($errors->has($name))
    <span class="error-text">{{$errors->first($name)}}</span>
    @endif
</div>
