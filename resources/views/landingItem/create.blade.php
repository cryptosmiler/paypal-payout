@extends('_layouts.master')

@section('body')
    <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['create_landing_item'] }} </h3>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">

            @if(session('success'))
                <div class=" text-green-500 mt-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('landingItem.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">

                    <div >
                        <label class="text-gray-700" for="username">Language</label>
                        <x-locale-select sLocale="{{ old('locale') }}" />
                    </div>

                    <div class=" col-span-1 sm:col-span-2">
                        <x-video-input
                            name="file"
                            videoSrc=""
                        />
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Title</label>
                        <input name="title" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('title') }}">
                        @error('title')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Description</label>
                        <textarea name="description" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" >{{ old('description') }}</textarea>
                        @error('description')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Order</label>
                        <input name="order" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="number" value="{{ old('order') }}">
                        @error('order')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-4 gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['save'] }} </button>
                    <a href="{{ route('landingItem.index') }}" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['cancel'] }} </a>
                </div>
            </form>
        </div>
    </div>


    <script>
    
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

@endsection

