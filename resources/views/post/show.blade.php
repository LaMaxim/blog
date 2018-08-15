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

                <div class="father-div height-div">
                    <h3><b>{{$post->title}}</b></h3>
                    <p>
                        <img class="show-left-img" style="" src="{{URL::asset('/post-images/' . $post->img)}}">
                        {{$post->text}}
                    </p>
                    <br><hr>
                    <div>
                        <div class="father-link">{{\Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}  by
                            {{$post->users()->first()->name}}
                        </div>
                    </div>
                    @inject('allowEditElements', 'App\Service\PermissionService')
                    @if($allowEditElements->allowEditElements(['admin', 'owner'], $post))
                    <div class="control-div">
                        <div class="control-buttons">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['post.destroy', $post->id]]) !!}
                            {!! Form::submit('Delete post', ['class' => 'btn btn-danger btn-xs']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div >
                            <a href="{{URL::to('post/edit/' . $post->id)}}" class="btn btn-default btn-xs">
                                Edit post
                            </a>
                        </div>
                    </div>
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
@endsection