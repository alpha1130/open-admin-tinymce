<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        
        <input id="{{$id}}" name="{{$name}}" class="tinymce-editor-{{$id}}" type="hidden" value="{{old($column, $value)}}">

        @include('admin::form.help-block')

    </div>
</div>