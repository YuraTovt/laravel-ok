<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View user') }} #{{ $user->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="mb-8">
                        <tbody>
                            <tr>
                                <td class="font-bold p-3">{{__('Id')}}:</td>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold p-3">{{__('Name')}}:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold p-3">{{__('Email')}}:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex items-center justify-end">
                        <x-link-button href="{{ route('users.index') }}">{{ __('Ok') }}</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>