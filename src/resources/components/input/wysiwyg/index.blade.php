<div class="form-group {{(@$horizontal)?'row':''}} {{($errors->has($name))?'has-error':''}} align-items-start">
    <label for="" class="label {{(@$horizontal)?'col-sm-2':'text-bold'}} mt-3">
        {{$label}}
        @if(!@$required)
        <span class="required">*</span>
        @endif
    </label>
    @if(@$horizontal)
    <div class="col-sm-6">
        <div id="editor_{{$name}}">
            {{$slot}}
        </div>
        @if($errors->has($name))
        <span class="error-text">{{$errors->first($name)}}</span>
        @endif
        {{@$help_text}}
    </div>
    @else
    <div id="editor_{{$name}}">
        {{$slot}}
    </div>
    @if($errors->has($name))
    <span class="error-text">{{$errors->first($name)}}</span>
    @endif
    {{@$help_text}}
    @endif
    <textarea name="{{$name}}" id="editor_{{$name}}_value" class="d-none">{{$slot}}</textarea>
</div>
@push('js')
<script>
    window["wysiwyg_{{$name}}"];
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],
        ['clean','image'],                         // remove formatting button
    ];
    window["wysiwyg_{{$name}}"] = new Quill('#editor_{{$name}}', {
        modules: {
            toolbar: toolbarOptions
        },
        placeholder: '{{@$placeholder}}',
        theme: 'snow'
    });
    window["wysiwyg_{{$name}}"].on('text-change', function(delta, oldDelta, source) {
        document.getElementById("editor_{{$name}}_value").value = window["wysiwyg_{{$name}}"].container.firstChild.innerHTML
    });
    //get html value = 
</script>
@endpush