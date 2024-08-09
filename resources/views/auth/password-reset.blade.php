@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center">
            <img src="{{ asset('assets/svg/logo.svg') }}" class="mt-1 ml-2 mr-2" />
            <span class="text-gray-700 font-semibold text-2xl"> {{ app('language')['password_reset'] }} </span>
        </div>

        <form class="mt-4" action="{{ route('reset-password.submit', ['token' => $token]) }}" method="POST">
            @csrf

            <input type="hidden" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="token" value="{{$token}}">

            @error('token')
                <span class=" text-red-600" role="alert">
                    {{ $message }}
                </span>
            @enderror

            <label class="block mt-3">
                <span class="text-gray-700 text-sm"> {{ app('language')['password'] }} </span>
                <input type="password" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="password">
                @error('password')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm"> {{ app('language')['password_confirmation'] }} </span>
                <input type="password" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="password_confirmation">
                @error('password_confirmation')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <div class="mt-6">
                <button class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500">
                    {{ app('language')['set_password'] }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
