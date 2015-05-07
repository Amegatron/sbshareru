@include('partials.preview')
<div class="form-group">
    <label for="news" class="col-sm-2 control-label">Новость</label>
    <div class="col-sm-5">
        {{ Form::textarea('news', null, array('class' => 'form-control bbeditor')) }}
    </div>
</div>
