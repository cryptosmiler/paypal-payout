@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center">
            <img src="{{ asset('assets/svg/logo.svg') }}" class="mt-1 ml-2 mr-2" />
            <span class="text-gray-700 font-semibold text-2xl"> {{ app('language')['login'] }} </span>
        </div>

        @error('inactivate')
            <span class=" text-red-600 text-center flex justify-center whitespace-pre-line" role="alert">{{ $message }}</span>
        @enderror

        @error('login_count_out')
            <span class=" text-red-600 text-center flex justify-center whitespace-pre-line" role="alert">{{ $message }}</span>
        @enderror

        <form class="mt-4" action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label class="block">
                <span class="text-gray-700 text-sm"> {{ app('language')['login'] }} </span>
                <input type="email" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="email">
                @error('email')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm"> {{ app('language')['password'] }} </span>
                <input type="password" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="password">
                @error('password')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <div class="flex justify-between items-center mt-4">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-indigo-600">
                        <span class="mx-2 text-gray-600 text-sm"> {{ app('language')['remember_me'] }} </span>
                    </label>
                </div>
                
                <div>
                    <a class="block text-sm fontme text-indigo-700 hover:underline" href="{{ route('reset-password-form.show') }}"> {{ app('language')['forgot_your_password'] }} </a>
                </div>
            </div>

            <div class="mt-6">
                <button class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500">
                    {{ app('language')['sign_in'] }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
