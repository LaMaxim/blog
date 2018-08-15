@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                {{--@foreach($post as $p)--}}
                {{--<div class="col-md-8 col-md-offset-2" style="border-radius: 10px; border: 2px solid CornflowerBlue;">--}}
                {{--<p>{{$p->id}}</p>--}}
                {{--<p>{{$p->title}}</p>--}}
                {{--<p>{{$p->text}}</p>--}}
                    {{--<div>--}}
                        {{--<p><a href="{{URL::to('post/' . $p->id . '/edit')}}" class="btn btn-default">Edit post</a></p>--}}
                        {{--{!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $p->id]]) !!}--}}
                        {{--{!! Form::submit('Delete post', ['class' => 'btn btn-danger']) !!}--}}
                        {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@endforeach--}}

                {{--{{$post->links()}}--}}

                </div>
            </div>
        </div>
    </div>
@endsection
