<div class="mb-6 flex gap-6" x-data="{ cropButtonVisible: false }">
    <div class="w-1/2 h-[350px]">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="multiple_files">Upload Image</label>
        <input name="{{ $name }}" x-on:change="cropButtonVisible = true;" class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="avatar" accept="image/*" @change="showPreview(event, $refs.previewSingle)" type="file">
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
        <div x-ref="previewSingle" id="previewSingle" class="mt-2 flex justify-center">
            @if($imageSrc)
            <img src="{{$imageSrc}}" class="aspect-auto shadow h-[250px]" />
            @else 
            <label class="block mb-2 text-sm font-medium text-red-400 dark:text-gray-300" for="multiple_files">{{ $requireText }}</label>
            @endif
        </div>
    </div>
    <div class="w-1/2 h-[350px] flex flex-col items-center justify-end">
        <div id="imagePreview" x-ref="imagePreview" class=" max-h-[300px] w-1/2"></div>
        <div class=" mt-1 mb-1">
            <button x-show="cropButtonVisible" type="button" class=" px-4 py-2 bg-green-400 text-gray-200 rounded-md hover:bg-green-300 focus:outline-none focus:bg-green-300" onclick="cropImage()">Crop</button>
            <button x-show="cropButtonVisible" type="button" class=" px-4 py-2 bg-red-400 text-gray-200 rounded-md hover:bg-red-300 focus:outline-none focus:bg-red-300" @click="$refs.imagePreview.replaceChildren(); cropButtonVisible=false;">Finish</button>
        </div>
    </div>
</div>

@error($name)
    <span class=" text-red-600" role="alert">
        {{ $message }}
    </span>
@enderror

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

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" integrity="sha512-JyCZjCOZoyeQZSd5+YEAcFgz2fowJ1F1hyJOXgtKu4llIa0KneLcidn5bwfutiehUTiOuK87A986BZJMko0eWQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" integrity="sha512-UtLOu9C7NuThQhuXXrGwx9Jb/z9zPQJctuAgNUBK3Z6kkSYT9wJ+2+dh6klS+TDBCV9kNPBbAxbVD+vCcfGPaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush