<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="referrer" content="always">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="stylesheet" href="{{ mix('css/app.css', '') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/css/intlTelInput.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/intlTelInput.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
        <script src="{{ mix('js/app.js', '') }}"></script>
        @stack('styles')
        @stack('scripts')
    </head>
    <body style="direction: {{ app()->currentLocale() == "en" ? "ltr": "rtl" }};">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
            @if(auth()->guard("admin")->check() && auth()->guard("admin")->user()->email_verified_at && auth()->guard("admin")->user()->phone_verified_at && Route::currentRouteName() !== "dashboard")
                @include('_layouts.sidebar')
            @endif

            <div class="flex-1 flex flex-col overflow-hidden">
                @include('_layouts.header')

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                @if(auth()->guard("admin")->check() && auth()->guard("admin")->user()->email_verified_at && auth()->guard("admin")->user()->phone_verified_at && Route::currentRouteName() !== "dashboard")
                    <div class="container mx-auto px-6 py-8">
                        @yield('body')
                    </div>
                @else
                    @yield('body')
                @endif

                </main>
            </div>

            <div class=" absolute h-[100vh] w-[100vw] justify-center items-center bg-white bg-opacity-80 flex z-50" id="loading" style="display: none;">
                <div class="dali-loader"></div>
            </div>
        </div>
        @if ($errors->any())
        <div class="flex justify-center absolute top-4 w-full">
            <div 
                class="inline-flex max-w-sm w-full bg-white shadow-md rounded-lg overflow-hidden ml-3 z-50 border-red-600 border" 
                x-data="{ open: true }" 
                x-show="open" 
                x-transition.duration.500ms 
                x-init="setTimeout(() => { open=false; }, 3000)"
            >
                <div class="flex justify-center items-center w-12 bg-red-500">
                    <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                    </svg>
                </div>
                
                <div class="-mx-3 py-2 px-4">
                    <div class="mx-3">
                        <span class="text-red-500 font-semibold">
                            {{ app('language')['error'] }}
                        </span>
                        <p class="text-sm text-black">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                                @break
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <script>
            $( document ).ajaxStart(function() {
                $( "#loading" ).show();
            });

            $( document ).ajaxStop(function() {
                $( "#loading" ).hide();
            });

            $(document).ready(function() {
                $('form').on('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    // Get the current local time
                    const localTime = moment().format('YYYY-MM-DD HH:mm:ss');

                    // Add the local time to a hidden input field
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'localTime',

                        value: localTime
                    }).appendTo(this);

                    // Submit the form with the local time added
                    this.submit();
                });

                $( ".datepicker" ).datepicker({
                    dateFormat: "yy-mm-dd", 
                    duration: "fast"
                });
            });

        </script>
    </body>
</html>
