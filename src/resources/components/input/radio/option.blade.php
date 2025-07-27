
<div class="form-radio {{@$class}}">
    <input type="radio" id="{{$name}}_{{strtolower($label)}}" {{(@$checked)?'checked':''}} class="" value="{{$value}}" name="{{$name}}" {{(@$required)?'':'required'}}>
    <label class="right" for="{{$name}}_{{strtolower($label)}}">{{$label}}</label>
</div>