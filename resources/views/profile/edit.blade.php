@extends('_layouts.master')

@section('body')
    <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['edit_profile'] }} </h3>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">

            @if(session('success'))
                <div class=" text-green-500 mt-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('profile.update') }}" method="POST" class="mt-4" enctype="multipart/form-data" id="profileForm" x-data="{ cropButtonVisible: false, showStripeKey: '{{auth()->guard('admin')->user()->stripe_api_key}}' === '', stripeAPIKey: '{{auth()->guard('admin')->user()->stripe_api_key}}' }" >
                @csrf
                {{method_field('PATCH')}}

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    <div class="sm:col-span-2" >
                        <div class="mb-6 flex gap-6">
                            <div class="w-1/2 h-[350px]">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="multiple_files">Upload avatar image</label>
                                <input name="file" x-on:change="cropButtonVisible = true;" class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="avatar" accept="image/*" @change="showPreview(event, $refs.previewSingle)" type="file">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                                <div x-ref="previewSingle" id="previewSingle" class="mt-2 flex justify-center">
                                    @if(auth()->guard('admin')->user()->avatar)
                                        <img class="aspect-auto shadow h-[250px]" src="{{ url(auth()->guard('admin')->user()->avatar) }}">
                                    @else
                                        <label class="block mb-2 text-sm font-medium text-red-400 dark:text-gray-300" for="multiple_files">Please select your avatar</label>
                                    @endif
                                </div>
                            </div>
                            <div class="w-1/2 h-[350px]">
                                <div id="imagePreview" x-ref="imagePreview" class=" max-h-[300px] w-1/2"></div>
                                <div class=" mt-1 mb-1">
                                    <button x-show="cropButtonVisible" type="button" class=" px-4 py-2 bg-green-400 text-gray-200 rounded-md hover:bg-green-300 focus:outline-none focus:bg-green-300" onclick="cropImage()">Crop</button>
                                    <button x-show="cropButtonVisible" type="button" class=" px-4 py-2 bg-red-400 text-gray-200 rounded-md hover:bg-red-300 focus:outline-none focus:bg-red-300" @click="$refs.imagePreview.replaceChildren(); cropButtonVisible=false;">Finish</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700" for="emailAddress">Email Address</label>
                        <input name="email" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="email" value="{{ auth()->guard('admin')->user()->email }}">
                        @error('email')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-gray-700" for="phone">Phone Number</label>
                        <input type="tel" id="phone" class="tel-input form-input mt-2 block w-full rounded-md focus:border-indigo-600" required="required" name="phone" value="{{ auth()->guard('admin')->user()->phone }}">
                        <input type="hidden" name="phone_prefix" id="phone_prefix" value="{{ old("phone_prefix", auth()->guard('admin')->user()->phone_prefix) }}" />
                        <input type="hidden" name="country_code" id="country_code" value="{{ old("country_code", auth()->guard('admin')->user()->country_code) }}" />
                        @error('phone')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">First Name</label>
                        <input name="first_name" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ auth()->guard('admin')->user()->first_name }}">
                        @error('first_name')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Last Name</label>
                        <input name="last_name" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ auth()->guard('admin')->user()->last_name }}">
                        @error('last_name')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Hebrew Name</label>
                        <input name="he_name" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ auth()->guard('admin')->user()->he_name }}">
                        @error('he_name')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Arabic Name</label>
                        <input name="ar_name" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ auth()->guard('admin')->user()->ar_name }}">
                        @error('ar_name')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>


                    <div>
                        <label class="text-gray-700" for="username">Paypal Email Address</label>

                        <div class="flex gap-2">
                            <input 
                                name="stripe_api_key" 
                                class="form-input w-full mt-2 rounded-md focus:border-indigo-600" 
                                type="text" 
                                x-show="showStripeKey"
                                x-model="stripeAPIKey"
                                @change="stripeAPIKey = $event.target.value"
                            />

                            <input 
                                class="form-input w-full mt-2 rounded-md focus:border-indigo-600" 
                                type="text" 
                                x-show="!showStripeKey"
                                x-model="stripeAPIKey.replace(/./g, '*')"
                                readonly
                            />


                            <button @click="showStripeKey = !showStripeKey; if(showStripeKey){ setTimeout(function(){showStripeKey = false;}, 5000) }" class="mt-2 px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" type="button" >
                                <svg x-show="!showStripeKey" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>

                                <svg x-show="showStripeKey" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </div>
                        @error('stripe_api_key')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-4 gap-4">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['save'] }} </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/utils.js",
            initialCountry: "<?php echo auth()->guard('admin')->user()->country_code; ?>", 
        });
    
    
        // store the instance variable so we can access it in the console e.g. window.iti.getNumber()
        window.iti = iti;

        input.addEventListener('countrychange', function() { 
            var countryData = iti.getSelectedCountryData();
            $("#country_code").val(countryData?.iso2?.toUpperCase());
            $("#phone_prefix").val(countryData?.dialCode);
        });
    
        var cropper;

        function showPreview(event, previewBox) {
            previewBox.replaceChildren();
    
            for (let i = 0; i < event.target.files.length; i++) {
                if (event.target.files[i] instanceof File) {
                    let img = document.createElement('img');
                    img.className = 'aspect-auto shadow h-[250px]';
                    img.src = URL.createObjectURL(event.target.files[i]);
                    previewBox.appendChild(img);
    
                }
            }
        }
    
        function cropImage() 
        {
            if( cropper )
            {
                // Get the cropped canvas
                var canvas = cropper.getCroppedCanvas();
    
                // Convert canvas to base64 encoded image
                var croppedImage = canvas.toDataURL();
    
                // Convert base64 image to Blob
                var blob = dataURItoBlob(croppedImage);
    
                // Create a new File object from Blob
                var croppedFile = new File([blob], 'cropped_image.jpg', { type: 'image/jpeg' });
    
                let img = document.createElement('img');
                img.className = 'aspect-auto shadow h-[250px]';
                img.src = croppedImage;
                $("#previewSingle")[0].replaceChildren();
                $("#previewSingle")[0].appendChild(img);


                // // Create a new file input element
                // var newInput = document.createElement('input');
                // newInput.type = 'file';
                // newInput.name = 'file';
                // newInput.multiple = false;
                // newInput.style.display = "none";

                // Create a FileList object with the single file
                var fileList = new DataTransfer();
                fileList.items.add(croppedFile);

                // Set the files property of the file input element by triggering a change event
                // newInput.files = fileList.files;

                document.getElementById("avatar").files = fileList.files;

                // $("#previewSingle").append(newInput);
            }
        }
    
        $('#avatar').on('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();
    
            reader.onload = function (event) {
                var imageUrl = event.target.result;
                var imagePreview = document.getElementById('imagePreview');
    
                // Clear previous preview
                imagePreview.innerHTML = '';
    
                // Create image element
                var img = document.createElement('img');
                img.src = imageUrl;
                img.id = 'previewImage';
                imagePreview.appendChild(img);
    
                // Initialize Cropper.js
                cropper = new Cropper(img, {
                    utoCrop: false,
                    ready() {
                        // Do something here
                        // ...
    
                        // And then
                        this.cropper.crop();
                    },
                });
            };
    
            reader.readAsDataURL(file);
        });
    
        // MARK: - Function to convert data URI to Blob
        function dataURItoBlob(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: 'image/jpeg' });
        }

    </script>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" integrity="sha512-JyCZjCOZoyeQZSd5+YEAcFgz2fowJ1F1hyJOXgtKu4llIa0KneLcidn5bwfutiehUTiOuK87A986BZJMko0eWQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" integrity="sha512-UtLOu9C7NuThQhuXXrGwx9Jb/z9zPQJctuAgNUBK3Z6kkSYT9wJ+2+dh6klS+TDBCV9kNPBbAxbVD+vCcfGPaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@endsection

