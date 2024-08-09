<div x-data="{ open: false }" class=" inline">
    <a
        @click="open=true"
        type="button"
        class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800 cursor-pointer">
        <svg class="h-5 w-5 inline-block"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="5" y1="12" x2="19" y2="12" /></svg>
        {{ app('language')['add_course'] }}
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
                    
                    <form action="{{ route('course.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                        @csrf
        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                            
                            <div >
                                <label class="text-gray-700" for="username">Subject</label>
                                <select name="subject_id" class="form-input w-full rounded-md focus:border-indigo-600" @change="if($event.target.value === 'create_new') { window.location.href = '{{ route('subject.create') }}'; }">
                                    @foreach ( $subjects as $subject )
                                        <option value="{{ $subject->id }}" {{ $subject->id == old('subject_id') ? "selected": '' }}> {{ $subject->title }} </option>
                                    @endforeach
                                    <option value="create_new"> 
                                        {{ app('language')['add_a_subject_of_your_own'] }}
                                    </option>
                                </select>
                            </div>
        
                            <div class=" col-span-1 sm:col-span-2">
                                <x-image-crop-input
                                    requireText="Please select brand image."
                                    name="image"
                                    imageSrc=""
                                />
                            </div>
        
                            <div class="col-span-1 sm:col-span-2" x-data="{ freeOfCharge: ['pay', 'on'].indexOf('{{ old('charge') }}') > -1 ? false : true }">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" >
                                    <label class="inline-flex items-center ml-3" >
                                        <input name="charge" type="checkbox" class="form-checkbox h-5 w-5 text-purple-600" :checked="freeOfCharge" @change="freeOfCharge = $event.target.checked"><span class="ml-2 text-gray-700" >Free of charge</span>
                                    </label>
                                    <label class="inline-flex items-center ml-3">
                                        <input name="visible" type="checkbox" class="form-checkbox h-5 w-5 text-purple-600" :checked="'{{ old('visible', 'show') }}' == 'show' ? true: false;"><span class="ml-2 text-gray-700" >Show</span>
                                    </label>
        
                                    <div x-show="!freeOfCharge">
                                        <label class="text-gray-700" for="username">Video Price (Cent)</label>
                                        <input name="video_price" class="form-input w-full mt-2 rounded-md focus:border-indigo-600 disabled:border-gray-300" type="number" value="{{ old('video_price', 100) }}" :disabled="freeOfCharge">
                                        @error('video_price')
                                            <span class=" text-red-600" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div x-show="!freeOfCharge">
                                        <label class="text-gray-700" for="username">Per Question Price (Cent)</label>
                                        <input name="question_price" class="form-input w-full mt-2 rounded-md focus:border-indigo-600 disabled:border-gray-300" type="number" value="{{ old('question_price', 10) }}" :disabled="freeOfCharge">
                                        @error('question_price')
                                            <span class=" text-red-600" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
        
                            <div x-data="{ coupon: '{{ old('coupon') }}' || Math.random().toString(36).substr(2, 6).split('').map(c => Math.random() > 0.5 ? c.toUpperCase() : c).join('') }">
                                <label class="text-gray-700" for="username">Coupon Code</label>
                                <div class="flex gap-2">
                                    <input name="coupon" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" :value="coupon" readonly>
                                    <button @click="coupon = Math.random().toString(36).substr(2, 6).split('').map(c => Math.random() > 0.5 ? c.toUpperCase() : c).join('');" class="mt-2 px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" type="button" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                                        </svg>
                                    </button>
                                </div>
                                @error('coupon')
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
        
                        <div class="flex justify-end mt-4 gap-4">
                            <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" >{{ app('language')['save'] }}</button>
                            <a @click="open=false;" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700 cursor-pointer" > {{ app('language')['cancel'] }} </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>