<div class="form-group {{(@$horizontal)?'row':''}} {{($errors->has($name))?'has-error':''}}">
    <label for="" class="label {{(@$horizontal)?'col-sm-2':'text-bold'}}">
        {{$label}}
        @if(!@$required)
        <span class="required">*</span>
        @endif
    </label>
    @if(@$horizontal)
        <div class="col-sm-6">
            <select name="{{$name}}" id="{{$name}}" class="form-control wide nice-select2 {{@$class}}" {{(@$required)?'':'required'}}>
                {{$slot}}
            </select>
            @if($errors->has($name))
            <span class="error-text">{{$errors->first($name)}}</span>
            @endif
        </div>
    @else
        <select name="{{$name}}" id="{{$name}}" class="form-control wide nice-select2 {{@$class}}" {{(@$required)?'':'required'}}>
            {{$slot}}
        </select>
        @if($errors->has($name))
        <span class="error-text">{{$errors->first($name)}}</span>
        @endif
    @endif
</div>