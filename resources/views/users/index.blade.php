@extends('components.layout')

@section('title')
    List users
@endsection

@section('main')
    <table>
        <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Email</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @if($paginator->isNotEmpty())
                @foreach($paginator->items() as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.show', ['user' => $user->id]) }}">View</a>
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}">Edit</a>
                            <a href="#" class="delete-user-link" data-user-id="{{ $user->id }}">Delete</a>
                            <form id="form-{{ $user->id }}" method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No users</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div>
        <a href="{{ $paginator->previousPageUrl() }}">Prev page</a>
        <a href="{{ $paginator->nextPageUrl() }}">Next page</a>
    </div>
    <div>
        <a href="users/create">Create</a>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function deleteUser(event) {
            event.preventDefault();

            const a = event.target;
            const form = document.getElementById(`form-${a.getAttribute('data-user-id')}`);

            if (confirm(`Are you sure you want to delete user #${a.getAttribute('data-user-id')}`)) {
                form.submit();
            }
        }

        window.addEventListener('load', function () {
            const elements = document.getElementsByClassName('delete-user-link');

            for (const el of elements) {
                el.addEventListener('click', deleteUser);
            }
        })
    </script>
@endsection