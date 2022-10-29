<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit user') }} #{{ $user->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}">
                        @method('PATCH')

                        <div class="w-1/3 mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input type="text" name="name" value="{{ $user->name }}" class="w-full"/>
                            @if (session('errors') && session('errors')->has('name'))
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            @endif
                        </div>

                        <div class="w-1/3 mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input type="text" name="email" value="{{ $user->email }}" class="w-full"/>
                            @if (session('errors') && session('errors')->has('email'))
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            @endif
                        </div>

                        <div class="w-1/3 mb-4">
                            <x-input-label for="old_password" :value="__('Old password')" />
                            <x-text-input type="text" name="old_password" class="w-full" />
                            @if (session('errors') && session('errors')->has('old_password'))
                                <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
                            @endif
                        </div>

                        <div class="w-1/3 mb-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input type="text" name="password" class="w-full" />
                            @if (session('errors') && session('errors')->has('password'))
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            @endif
                        </div>

                        @csrf

                        <div class="flex items-center justify-end">
                            <x-primary-button class="mr-2">{{ __('Update') }}</x-primary-button>
                            <x-link href="{{ route('users.index') }}">{{ __('Cancel') }}</x-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>