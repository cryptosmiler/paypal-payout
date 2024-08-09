@extends('_layouts.master')

@section('body')
    <div class="flex flex-row justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['create_lecture'] }} </h3>
    </div>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">

            @if(session('success'))
                <div class=" text-green-500 mt-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('lecture.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4" x-data="{ subjectOption: '{{ $course->subject_id ?? 0 }}', courseOption: '{{ $course->id ?? 0 }}', courseOptions: {{ $courses }} }">
                    
                    <div >
                        <label class="text-gray-700" for="subject_id">Subject</label>
                        <select name="subject_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="subjectOption" @change="console.log(subjectOption)" >
                            @foreach ( $subjects as $subject )
                                <option value="{{ $subject->id }}" {{ $subject->id == old('subject_id') ? "selected": '' }}> {{ $subject->title }} </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div >
                        <label class="text-gray-700" for="course_id">Course</label>
                        <select name="course_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="courseOption">
                            <template x-for="course in courseOptions.filter((c) => c.subject_id == subjectOption)" :key="course.id">
                                <option x-text="course.title" :value="course.id"></option>
                            </template>
                        </select>
                        @error('course_id')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class=" col-span-1 sm:col-span-2">
                        <x-video-input
                            name="video"
                            :isInfo="true"
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

                <div class="flex justify-end mt-4 gap-4">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" >{{ app('language')['save'] }}</button>
                    <a href="{{ route('lecture.index') }}" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['cancel'] }} </a>
                </div>
            </form>
        </div>
    </div>

@endsection

