@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @foreach($post as $p)
                    <div style="border-radius: 10px; border: 1px solid rgb(207,224,232); background-color: rgb(255,255,255);">
                        <p>{{$p->id}}</p>
                        <p>{{$p->title}}</p>
                        <p>{{$p->text}}</p>
                        <p><div><img style="max-width: 20px" src="{{URL::asset('/post-images/3.jpeg')}}"></div></p>
                        <p><a href="{{url('post', $p->id)}}" >Show</a></p>
                        <div>
                            <p><a href="{{URL::to('post/' . $p->id . '/edit')}}" class="btn btn-default">Edit post</a></p>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $p->id]]) !!}
                            {!! Form::submit('Delete post', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endforeach

                {{$post->links()}}

            </div>
        </div>
    </div>
    </div>
@endsection
