<div class="w-100 me-2 form-control form-radio d-flex align-items-center justify-content-between {{@$class}}">
    <label for="{{$name}}_{{strtolower($label)}}">{{$label}}</label>
    <input type="radio" id="{{$name}}_{{strtolower($label)}}" {{(@$checked)?'checked':''}} value="{{$value}}" name="{{$name}}" {{(@$required)?'':'required'}}>
</div>