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
        <textarea  name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}" {{$attributes}} placeholder="{{@$placeholder}}" cols="30" rows="3">{{$slot}}</textarea>
        @if($errors->has($name))
        <span class="error-text">{{ucfirst($errors->first($name))}}</span>
        @endif
    </div>
    @else
    <textarea  name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}" {{$attributes}} placeholder="{{@$placeholder}}" cols="30" rows="3">{{$slot}}</textarea>
    @if($errors->has($name))
    <span class="error-text">{{ucfirst($errors->first($name))}}</span>
    @endif
    @endif
</div>