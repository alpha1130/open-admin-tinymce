<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        
        <textarea id="{{$id}}" class="tinymce-editor-{{$id}}" style="height: 400px;">{!! old($column, $value) !!}</textarea>

        @include('admin::form.help-block')

    </div>
</div>