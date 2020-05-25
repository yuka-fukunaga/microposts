@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            @include('users.card', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            @include('users.navtabs', ['user' => $user])
            @if (Auth::id() == $user->id)
                        {!! Form::open(['route' => 'upload', 'files' => true]) !!}
                            <div class="form-group">
                                {!! Form::label('textarea', '投稿',['class' => 'control-label']) !!}
                                {!! Form::textarea('content',null,['class' => 'form-control'])!!}
                                {!! Form::file('file') !!}
                            </div>
                            <div class="form-group text-center">
                                {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                {!! Form::close() !!}
            @endif
            @if (count($microposts) > 0)
                @include('microposts.microposts', ['microposts' => $microposts])
            @endif
        </div>
    </div>
@endsection