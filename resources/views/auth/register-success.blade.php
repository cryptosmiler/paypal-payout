@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center flex-col gap-2">
            <span class="text-gray-700 font-semibold text-2xl"> {{ app('language')['register_success'] }} </span>
            <span class="text-gray-700"> {{ app('language')['we_sent_you_an_email_to_complete_registration'] }} </span>
        </div>

    </div>
</div>
@endsection
