@extends('components.layout')

@section('title')
    Edit user #{{ $user->id }}
@endsection

@section('main')
    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}">
        @method('PATCH')

        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}"/>
            @if (session('errors') && session('errors')->has('name'))
                <span>{{ session('errors')->first('name') }}</span>
            @endif
        </div>

        <div>
            <label>Email</label>
            <input type="text" name="email" value="{{ $user->email }}"/>
            @if (session('errors') && session('errors')->has('email'))
                <span>{{ session('errors')->first('email') }}</span>
            @endif
        </div>

        <div>
            <label>Old password</label>
            <input type="text" name="old_password"/>
            @if (session('errors') && session('errors')->has('old_password'))
                <span>{{ session('errors')->first('old_password') }}</span>
            @endif
        </div>

        <div>
            <label>Password</label>
            <input type="text" name="password"/>
            @if (session('errors') && session('errors')->has('password'))
                <span>{{ session('errors')->first('password') }}</span>
            @endif
        </div>

        @csrf

        <div>
            <input type="submit" value="Update">
            <a href="{{ route('users.index') }}">Cancel</a>
        </div>
    </form>
@endsection