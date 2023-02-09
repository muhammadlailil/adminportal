
<div class="form-checkbox {{@$class}}">
    <input type="checkbox" id="{{$name}}_{{strtolower($label)}}" {{(@$checked)?'checked':''}} value="{{$value}}" name="{{$name}}" {{(@$required)?'':'required'}}>
    <label class="right" for="{{$name}}_{{strtolower($label)}}">{{$label}}</label>
</div>