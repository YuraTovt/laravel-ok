@extends('components.layout')

@section('title')
    Show user
@endsection

@section('main')
    <table>
        <tbody>
            <tr>
                <td>Id</td>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $user->email }}</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('users.index') }}">Ok</a>
@endsection