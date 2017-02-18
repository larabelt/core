<div class="well well-sm">
    <h1>Contact US</h1>
    {!! Form::open([
        'url'=>'/contact'
    ]) !!}
    <div class="form-group">
        {!! Form::text('name', null, ['class'=> 'form-control', 'placeholder' => 'name']) !!}
    </div>
    <div class="form-group">
        {!! Form::text('email', null, ['class'=> 'form-control', 'placeholder' => 'name']) !!}
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
    {!! Form::close() !!}
</div>