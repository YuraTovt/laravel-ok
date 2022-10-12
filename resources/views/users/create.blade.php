@extends('components.layout')

@section('title')
    Create user
@endsection

@section('main')
    <form method="POST" action="{{ route('users.store') }}">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}"/>
            @if (session('errors') && session('errors')->has('name'))
                <span>{{ session('errors')->first('name') }}</span>
            @endif
        </div>

        <div>
            <label>Email</label>
            <input type="text" name="email" value="{{ old('email') }}"/>
            @if (session('errors') && session('errors')->has('email'))
                <span>{{ session('errors')->first('email') }}</span>
            @endif
        </div>

        <div>
            <label>Password</label>
            <input type="text" name="password" />
            @if (session('errors') && session('errors')->has('password'))
                <span>{{ session('errors')->first('password') }}</span>
            @endif
        </div>

        @csrf

        <div>
            <input type="submit" value="Create">
            <a href="{{ route('users.index') }}">Cancel</a>
        </div>
    </form>
@endsection