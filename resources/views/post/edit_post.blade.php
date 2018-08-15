@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('messages.msg')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit post</div>
                    <div>
                        {!! Form::model($post, array('route' => array('post.update', $post->id), 'method' => 'PUT')) !!}
                        {!! Form::token() !!}
                            <div class="form-group">
                                <div class="col-md-2">
                                    {{ Form::label('title', 'Title') }}
                                </div>
                                <div class="col-md-10">
                                    {{ Form::text('title', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    {{ Form::label('text', 'Content') }}
                                </div>
                                <div class="col-md-10">
                                    {{ Form::textarea('text', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-md-offset-10">
                                    {{ Form::submit('Edit post', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection