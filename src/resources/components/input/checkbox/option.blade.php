@php
    if(!@$attributes['required']){
        $attributes['required'] = true;
    }else{
        unset($attributes['required']);
    }
    $required = @$attributes['required'];
@endphp
<div class="form-checkbox {{@$class}} d-flex justify-content-center">
    <input type="checkbox" id="{{$name}}_{{strtolower($label)}}" value="{{$value}}" name="{{$name}}" {{$attributes}}>
    <label class="right" for="{{$name}}_{{strtolower($label)}}">{{$label}}</label>
</div>