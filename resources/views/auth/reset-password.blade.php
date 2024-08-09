@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center">
            <img src="{{ asset('assets/svg/logo.svg') }}" class="mt-1 ml-2 mr-2" />
            <span class="text-gray-700 font-semibold text-2xl"> {{ app('language')['reset_password'] }} </span>
        </div>

        <form class="mt-4" action="{{ route('reset-password-email') }}" method="GET">
            @csrf

            <label class="block">
                <span class="text-gray-700 text-sm"> {{ app('language')['email'] }} </span>
                <input type="email" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            @if(session('status'))
                <div class=" text-green-500">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mt-6">
                <button class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500">
                    {{ app('language')['reset_password'] }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
