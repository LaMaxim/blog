@extends('layouts.app')

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

                <div class="panel-body" style="display: none">
                    <div>
                        @foreach($post->comments as $comment)
                            {{$comment->user}}
                            {{$comment->user->roles}}
                        @endforeach
                    </div>
                </div>
            @verbatim
                <div class="col-md-10 col-md-offset-2" id="comments-container">
                    <div id="form" v-if="currentUser">
                        <div id="comment-form">
                            <textarea v-model="value" placeholder="Enter your comment"></textarea>
                        </div>
                        <div id="send-comment">
                            <button class="btn btn-primary" @click="clickSendComment">Send</button>
                        </div>
                    </div>
                    <div id="comment-list">
                        <div v-for="comment in comments">
                            <div class="comment">
                                <div class="user">
                                    <span>{{getCreatedAtCommentText(comment.created_at)}}</span>
                                    <span>{{comment.user.name}}</span>
                                </div>
                                <div class="comment-value">
                                    <span>{{comment.text}}</span>
                                </div>
                                <div v-if="currentUser && currentUser.roles[0].name === EDITOR_ROLE" class="option-btn-container">
                                    <button class="btn btn-default btn-xs" @click="clickEditComment(comment.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs" @click="clickDeleteComment(comment.id)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endverbatim
        </div>
    </div>
</div>

@if(isset($post->comments))
    <script>window._globals = {!! json_encode([
    'comments' => $post->comments,
    'currentUser' => \Illuminate\Support\Facades\Auth::user(),
    'currentPostId' => $post->id
    ]) !!}</script>
@endif
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{asset('js/vue' . (env('APP_ENV') !== 'local' ? '.min' : '') . '.js' )}}"></script>
<script src="{{ asset('js/comments/comments.js') }}"></script>

@endsection
