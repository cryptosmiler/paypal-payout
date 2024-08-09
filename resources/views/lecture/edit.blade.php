@extends('_layouts.master')

@section('body')
    <div class="flex flex-row justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['edit_lecture'] }} </h3>
    </div>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">
            
            <form action="{{ route('lecture.update', $lecture->id) }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf
                {{method_field('PATCH')}}

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4" x-data="{ subjectOption: {{ $lecture->subject_id }}, courseOption: {{ $lecture->course_id }}, courseOptions: {{ $courses }} }">
                    
                    <div >
                        <label class="text-gray-700" for="subject_id">Subject</label>
                        <select name="subject_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="subjectOption" @change="console.log(subjectOption)">
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
                            videoSrc="{{ $lecture->video }}"
                            :duration="$lecture->duration"
                            :size="$lecture->size"
                        />
                    </div>

                    
                    <div>
                        <label class="text-gray-700" for="username">Title</label>
                        <input name="title" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('title', $lecture->title) }}">
                        @error('title')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Description</label>
                        <textarea name="description" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" >{{ old('description', $lecture->description) }}</textarea>
                        @error('description')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Order</label>
                        <input name="order" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="number" value="{{ old('order', $lecture->order) }}">
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

    {{-- <div class="flex flex-row justify-between mt-8">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['questions'] }} </h3>
    </div>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">
            
            <form action="{{ route('question.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf

                <input type="hidden" name="subject_id" value="{{ $lecture->subject_id }}" />
                <input type="hidden" name="course_id" value="{{ $lecture->course_id }}" />
                <input type="hidden" name="lecture_id" value="{{ $lecture->id }}" />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4" >
                    
                    <div>
                        <label class="text-gray-700" for="username">Question</label>
                        <input name="question" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('question') }}">
                        @error('question')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div >
                        <label class="text-gray-700" for="username">Answer</label>
                        <div class="flex gap-4">
                            <input name="answer" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('answer') }}">
                            <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700  mt-2" >{{ app('language')['add'] }}</button>
                        </div>
                        @error('answer')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>
            </form>

            <table class="min-w-full mt-8">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Question</th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @php
                        $i = 1;
                    @endphp
                    @foreach($lecture->questions as $question)
                    @if( $question->status == "created" )
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $i ++ }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $question->question }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $question->answer }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                            <x-delete-modal 
                                title="Delete Question"
                                content="Are you sure you want to delete this question?"
                                url="{{ route('question.destroy', $question->id) }}"
                            />
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

@endsection

