@extends('layouts.app')

@section('content')
    <div class="container">
        {!! Form::open(['action' => ['NotesController@update', $note->id], 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::textarea('note_content', $note->note_content, ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
                {{ Form::text('project_id', $note->project_id) }}
            </div>
            {{ Form::hidden('_method', 'PUT')}}
            {{ Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection