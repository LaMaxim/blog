@extends('layouts.app')

@section('page_js')
    <script src="{{asset('js/vue' . (env('APP_ENV') !== 'local' ? '.min' : '') . '.js' )}}"></script>
    <script src="{{asset('js/comments/comments.js')}}"></script>
@endsection

@section('content')
    @include('messages.msg')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Show</div>
                <div class="col-md-9 col-md-offset-1">
                    <h3>{{$post->title}}</h3>
                    <p>{{$post->text}}</p>
                    <p>{{\Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}
                    <p><div><img style="max-width: 20px" src="{{URL::asset('/post-images/3.jpeg')}}"></div></p>



                    @inject('allowEditElements', 'App\Http\Controllers\PostController')
                    @if($allowEditElements->allowEditElements(['admin', 'owner'], $post))
                        <p>
                            <a href="{{URL::to('post/' . $post->id . '/edit')}}" class="btn btn-default">
                                Edit post
                            </a>
                        </p>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $post->id]]) !!}
                        {!! Form::submit('Delete post', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endif

                </div>



                <div class="panel-body">

                    <div>
                        @foreach($post->comments as $comment)
                            <div>
                                {{$comment->text}}
                                {{$comment->user->name}}
                            </div>
                        @endforeach
                    </div>

                </div>
                <div id="comments-container">
                    <div>
                        {{--{{message}}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection