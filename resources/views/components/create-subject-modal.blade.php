<div x-data="{ open: false }" class=" inline">
    <a
        @click="open=true"
        type="button"
        class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800 cursor-pointer">
        <svg class="h-5 w-5 inline-block"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="5" y1="12" x2="19" y2="12" /></svg>
        {{ app('language')['add_subject'] }}
    </a>
    
    <div x-show="open" class="font-sans antialiased fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
    
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-5xl sm:w-full">
            <div class="mt-8">
                <div class="p-6 bg-white rounded-md shadow-md">
        
                    @if(session('success'))
                        <div class=" text-green-500 mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('subject.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                        @csrf
        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                            
                            <div >
                                <label class="text-gray-700" for="username">Language</label>
                                <x-locale-select sLocale="{{ old('locale') }}" />
                            </div>
        
                            <div class=" col-span-1 sm:col-span-2">
                                <x-image-crop-input
                                    requireText="Please select brand image."
                                    name="file"
                                    imageSrc=""
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
        
                        </div>
        
                        <div class="flex justify-end mt-4 gap-4">
                            <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" >{{ app('language')['save'] }}</button>
                            <a @click="open = false;" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700 cursor-pointer" > {{ app('language')['cancel'] }} </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>