@php
    if (!@$attributes['required']) {
        $attributes['required'] = true;
    } else {
        unset($attributes['required']);
    }
    $required = @$attributes['required'];
@endphp
<div class="form-group {{ @$horizontal ? 'row' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="" class="label {{ @$horizontal ? 'col-sm-2' : 'text-bold' }}">
        {{ $label }}
        @if (@$required)
            <span class="required">*</span>
        @endif
    </label>
    @if (@$horizontal)
        <div class="col-sm-6">
            <input type="{{ $type }}" {{ $attributes }} name="{{ $name }}" id="{{ $name }}"
                class="form-control {{ @$class }}" placeholder="{{ @$placeholder }}" value="{{ $slot }}">
            @if ($errors->has($name))
                <span class="error-text">{{ $errors->first($name) }}</span>
            @endif
            @if (@$helpText)
                <span class="help-text">{{ @$helpText }}</span>
            @endif
        </div>
    @else
        <input type="{{ $type }}" {{ $attributes }} name="{{ $name }}" id="{{ $name }}"
            class="form-control {{ @$class }}" placeholder="{{ @$placeholder }}" value="{{ $slot }}">
        @if ($errors->has($name))
            <span class="error-text">{{ $errors->first($name) }}</span>
        @endif
        @if (@$helpText)
            <span class="help-text">{{ @$helpText }}</span>
        @endif
    @endif
</div>
