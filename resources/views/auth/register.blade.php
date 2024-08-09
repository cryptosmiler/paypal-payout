@extends('_layouts.master')

@section('body')   
<div class="flex justify-center items-center min-h-[calc(100vh_-_66px)] orange-gradient px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center">
            <img src="{{ asset('assets/svg/logo.svg') }}" class="mt-1 ml-2 mr-2" />
            <span class="text-gray-700 font-semibold text-2xl"> {{ app('language')['register'] }} </span>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" class="mt-4">
            @csrf

            <label class="block">
                <span class="text-gray-700 text-sm"> {{ app('language')['first_name'] }} </span>
                <input type="first_name" name="first_name" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" value="{{ old("first_name") }}">
                @error('first_name')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700 text-sm"> {{ app('language')['last_name'] }} </span>
                <input type="last_name" name="last_name" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" value="{{ old("last_name") }}">
                @error('last_name')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700 text-sm"> {{ app('language')['email'] }} </span>
                <input type="email" name="email" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" required="required" value="{{ old("email") }}">
                @error('email')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block">
                <span class="text-gray-700 text-sm"> {{ app('language')['phone_number'] }} </span>
                <input type="tel" id="phone" class="tel-input form-input mt-1 block w-full rounded-md focus:border-indigo-600" required="required" name="phone" value="{{ old("phone") }}">
                <input type="hidden" name="phone_prefix" id="phone_prefix" value="{{ old("phone_prefix", "972") }}" />
                <input type="hidden" name="country_code" id="country_code" value="{{ old("country_code", "IL") }}" />
                @error('phone')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm"> {{ app('language')['password'] }} </span>
                <input type="password" name="password" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600">
                @error('password')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm"> {{ app('language')['password_confirmation'] }} </span>
                <input type="password" name="password_confirmation" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600">
                @error('password_confirmation')
                    <span class=" text-red-600" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <div class="mt-6">
                <button class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500">
                    {{ app('language')['register'] }}
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/utils.js",
        initialCountry: 'IL', 
    });


    // store the instance variable so we can access it in the console e.g. window.iti.getNumber()
    window.iti = iti;

    input.addEventListener('countrychange', function() { 
        var countryData = iti.getSelectedCountryData();
        $("#country_code").val(countryData?.iso2?.toUpperCase());
        $("#phone_prefix").val(countryData?.dialCode);
    });
</script>
@endsection