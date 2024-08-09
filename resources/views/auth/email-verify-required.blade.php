@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center flex-col gap-2">
            <span class="text-gray-700 font-semibold text-2xl">{{ app('language')['you_need_to_email_verify'] }}</span>
            <span class="text-gray-700">{{ app('language')['did_you_receive_verification_email_yet'] }}</span>
            <a href="{{ route('resend-email-verification') }}" class=" underline text-blue-500"> {{ app('language')['resend_email_verification'] }} </a>
        </div>

    </div>
</div>
@endsection
