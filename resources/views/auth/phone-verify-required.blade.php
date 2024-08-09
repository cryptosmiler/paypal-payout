@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">



        <form class="flex justify-center items-center flex-col gap-2" action="{{ route('phone-verify.submit') }}" method="POST">
            @csrf

            <span class="text-gray-700 font-semibold text-2xl"> {{ app('language')['you_need_to_phone_verify'] }} </span>
        
            @error('verify_count_out')
                <span class=" text-red-600 text-center my-2 text-wrap whitespace-pre-line" role="alert">{{ $message }}</span>
            @enderror
            
            <!-- <input type="tel" id="phone" class="tel-input form-input mt-1 block w-full rounded-md focus:border-indigo-600" required="required" name="phone"> -->
            <div class="relative flex flex-row">
                <input type="string" name="phone_verification_token" class="form-input block w-full rounded-md focus:border-indigo-600" placeholder="{{ app('language')['verification_code_here'] }}">
                <button class="px-3 bg-green-600 rounded-md text-white font-medium tracking-wide hover:bg-green-500 ml-3 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                    </svg>
                </button>
            </div>
            @error('phone_verification_token')
                <span class=" text-red-600 text-center" role="alert">
                    {{ $message }}
                </span>
            @enderror
            <span class="text-gray-700"> {{ app('language')['didnt_you_receive_verification_sms_yet'] }} </span>
            <a href="{{ route('resend-phone-verification') }}" class=" underline text-blue-500"> {{ app('language')['resend_phone_verification'] }} </a>
        </form>

    </div>
</div>
@endsection
