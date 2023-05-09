@php
    if(!@$attributes['required']){
        $attributes['required'] = true;
    }else{
        unset($attributes['required']);
    }
    $required = @$attributes['required'];
@endphp
<div class="w-100 me-2 form-control form-checkbox d-flex align-items-center justify-content-between {{@$class}}">
    <label for="{{$name}}_{{strtolower($label)}}">{{$label}}</label>
    <input type="checkbox" id="{{$name}}_{{strtolower($label)}}" value="{{$value}}" name="{{$name}}" {{$attributes}}>
</div>