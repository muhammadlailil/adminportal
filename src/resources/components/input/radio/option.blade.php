@php
    if(!@$attributes['required']){
        $attributes['required'] = true;
    }else{
        unset($attributes['required']);
    }
    $required = @$attributes['required'];
@endphp

<div class="form-radio {{@$class}}">
    <input @checked(@$attributes['selected']) type="radio" id="{{$name}}_{{strtolower($label)}}" class="" value="{{$value}}" name="{{$name}}" {{$attributes}}>
    <label class="right" for="{{$name}}_{{strtolower($label)}}">{{$label}}</label>
</div>