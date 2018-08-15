@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @foreach($posts as $post)
                    <div class="father-div">
                        <h4><b>{{$post->title}}</b></h4>
                        <p>
                            <img class="father-left-img" style="" src="{{URL::asset('/post-images/' . $post->img)}}">
                            {{substr($post->text, 0, 320)}}...
                        </p>
                        <div>
                            <div class="float-left">{{\Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}  by
                                {{$post->users()->first()->name}}
                            </div>
                            <div class="father-link"><a href="{{url('post/view', $post->id)}}" >Read More...</a></div>
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
                @endforeach

                {{$posts->links()}}

            </div>
        </div>
    </div>

@endsection
