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
        <div class="input-group-radio d-flex">
            {{$slot}}
        </div>
        @if($errors->has($name))
        <span class="error-text">{{$errors->first($name)}}</span>
        @endif
    </div>
    @else
    {{$slot}}
    @if($errors->has($name))
    <span class="error-text">{{$errors->first($name)}}</span>
    @endif
    @endif
</div>