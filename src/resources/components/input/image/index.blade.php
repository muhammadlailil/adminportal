<div class="form-group {{(@$horizontal)?'row':''}} {{($errors->has($name))?'has-error':''}}">
    <label for="" class="label {{(@$horizontal)?'col-sm-2':'text-bold'}}">
        {{$label}}
        @if(!@$required)
        <span class="required">*</span>
        @endif
    </label>
    @if(@$horizontal)
    <div class="col-sm-6">
        <div class="form-image-upload rounded"
            style="background-image: url('{{asset($slot)}}');">
            <input type="file" name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}"
                {{(@$required)?'':'required'}} accept="image/*">
        </div>
    </div>
    @else
    <div class="form-image-upload rounded"
        style="background-image: url('{{asset($slot)}}');">
        <input type="file" name="{{$name}}" id="{{$name}}" class="form-control {{@$class}}"
            {{(@$required)?'':'required'}} accept="image/*">
    </div>
    @endif
    @if($errors->has($name))
    <span class="error-text">{{$errors->first($name)}}</span>
    @endif
</div>