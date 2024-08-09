<div class="mb-6 flex gap-6 flex-col" x-data="{ videoFile: '', fileSelected: false,  }">
    <div class="w-1/2 h-[350px]">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="multiple_files">Upload Video</label>
        <input name="{{ $name }}" @change="videoFile = $event.target.files[0]; fileSelected=true;" class="block w-full h-10.5 leading-9 rounded overflow-hidden text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="video" accept="video/*" type="file">
        <span class=" text-red-600 hidden" role="alert" id="video_error"></span>
        <div x-ref="previewSingle" id="previewSingle" class="mt-2 flex justify-center min-h-[250px]">
            <video :src="fileSelected == false ? '{{ '../../storage/'.$videoSrc }}' : URL.createObjectURL(videoFile)" controls autoplay class=" min-h-[250px] h-[250px]" ></video>
        </div>

        
        
    </div>
    @if($isInfo)
    <div class="w-1/2 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div>
            <label class="text-gray-700" for="username">Video Minute (min)</label>
            <input id="min" class="form-input w-full mt-2 rounded-md focus:border-indigo-600 disabled:border-gray-300" type="number" readonly >
            @error('min')
                <span class=" text-red-600" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div>
            <label class="text-gray-700" for="username">Video Second (s)</label>
            <input id="sec" class="form-input w-full mt-2 rounded-md focus:border-indigo-600 disabled:border-gray-300" type="number" readonly >
            @error('sec')
                <span class=" text-red-600" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div>
            <label class="text-gray-700" for="username">Video Size (MB)</label>
            <input name="size" id="size" class="form-input w-full mt-2 rounded-md focus:border-indigo-600 disabled:border-gray-300" type="number" value="{{ $size }}" readonly>
            @error('size')
                <span class=" text-red-600" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <input id="duration" name="duration" class="form-input w-full mt-2 rounded-md focus:border-indigo-600 disabled:border-gray-300" type="hidden" value="{{ $duration }}" >
    </div>
    @endif
</div>

@error($name)
    <span class=" text-red-600" role="alert">
        {{ $message }}
    </span>
@enderror

<script>
    window.URL = window.URL || window.webkitURL;
    var myVideos = [];
    const name_id = "{{ $name }}";
    const isInfo = "{{ $isInfo }}" === "1";
    const duration = Number("{{ $duration }}");
    const maxFileSize = Number("{{ app('setting')['max_file_size'] }}");

    $(document).ready(function(){
        $("form").on("submit", function(){
           $("#loading").show();
        });
        if(isInfo) {
            $(`#${name_id}`).on('change', function(e){
                const file = e.target.files[0];
                
                if (file) {
                    // File size
                    const fileSize = file.size;
                    const fileSizeInMB = fileSize / 1024 / 1024; // Convert to MB
                    $("#size").val(fileSizeInMB.toFixed(0));

                    if( fileSizeInMB > maxFileSize ) {
                        $("#video_error").text("File size is too large. Max file size is " + maxFileSize + " MB");
                        $("#video_error").show();
                    }
    
                    // Video duration
                    const video = document.createElement('video');
                    video.preload = 'metadata';
                    video.onloadedmetadata = function() {
                        window.URL.revokeObjectURL(video.src);
                        const duration = video.duration;
                        const durationInMinutes = Math.floor(duration / 60);
                        const durationInSeconds = Math.floor(duration % 60);
                        $("#duration").val(duration);
                        $("#min").val(durationInMinutes);
                        $("#sec").val(durationInSeconds);

                    };
                    video.src = URL.createObjectURL(file);
                }
            });

            $("#min").val( Math.floor(duration / 60) );
            $("#sec").val( duration % 60 );
        }
    });
</script>