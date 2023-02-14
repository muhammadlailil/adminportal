<div class="form-group {{(@$horizontal)?'row':''}} {{($errors->has($name))?'has-error':''}}">
    <label for="" class="label {{(@$horizontal)?'col-sm-2':'text-bold'}}">
        {{$label}}
        @if(!@$required)
        <span class="required">*</span>
        @endif
    </label>
    @if(@$horizontal)
    <div class="col-sm-6">
        <input type="{{$type}}" {{@$step?'step='.$step.'':''}} name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}" {{(@$required)?'':'required'}} placeholder="{{@$placeholder}}" value="{{$slot}}">
        @if($errors->has($name))
        <span class="error-text">{{$errors->first($name)}}</span>
        @endif
        {{@$help_text}}
    </div>
    @else
    <input type="{{$type}}" {{@$step?'step='.$step.'':''}} name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}" {{(@$required)?'':'required'}} placeholder="{{@$placeholder}}" value="{{$slot}}">
    @if($errors->has($name))
    <span class="error-text">{{$errors->first($name)}}</span>
    @endif
    {{@$help_text}}
    @endif
</div>