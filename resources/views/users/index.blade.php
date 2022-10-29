<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8 flex items-center justify-end">
                        <x-link-button href="users/create">Create</x-link-button>
                    </div>
                    <table class="w-full mb-8">
                        <thead>
                            <tr>
                                <td class="px-3 py-3 font-bold">{{__('Id')}}</td>
                                <td class="px-3 py-3 font-bold">{{__('Name')}}</td>
                                <td class="px-3 py-3 font-bold">{{__('Email')}}</td>
                                <td class="px-3 py-3 font-bold"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if($paginator->isNotEmpty())
                                @foreach($paginator->items() as $user)
                                    <tr>
                                        <td class="px-3 py-3">{{ $user->id }}</td>
                                        <td class="px-3 py-3">{{ $user->name }}</td>
                                        <td class="px-3 py-3">{{ $user->email }}</td>
                                        <td class="px-3 py-3 text-end w-52">
                                            <x-link href="{{ route('users.show', ['user' => $user->id]) }}" class="mr-2">View</x-link>
                                            <x-link href="{{ route('users.edit', ['user' => $user->id]) }}" class="mr-2">Edit</x-link>
                                            <x-link href="#" class="delete-user-link" data-user-id="{{ $user->id }}">Delete</x-link>
                                            <form id="form-{{ $user->id }}" method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center p-5 italic">{{__('No users')}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="flex items-center justify-end">
                        <x-pagination-link href="{{ $paginator->previousPageUrl() }}" class="mr-2">{{__('Prev page')}}</x-pagination-link>
                        <x-pagination-link href="{{ $paginator->nextPageUrl() }}">{{__('Next page')}}</x-pagination-link>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</x-app-layout>