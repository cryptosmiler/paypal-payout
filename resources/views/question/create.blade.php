@extends('_layouts.master')

@section('body')

    <div class="flex flex-row justify-between mt-8">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['create_question'] }} </h3>
    </div>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md" >
            
            <form action="{{ route('question.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4" x-data="{ subjectOption: '{{ $course->subject_id ?? 0 }}', courseOption: '{{ $course->id ?? 0 }}', lectureOption: '{{ $lecture->id ?? 0 }}', courseOptions: {{ $courses }}, lectureOptions: {{ $lectures }} }" >

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

                    <div >
                        <label class="text-gray-700" for="lecture_id">Lecture</label>
                        <select name="lecture_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="lectureOption">
                            <template x-for="lecture in lectureOptions.filter((l) => l.course_id == courseOption)" :key="lecture.id">
                                <option x-text="lecture.title" :value="lecture.id" :selected=" lecture.id == lectureOption "></option>
                            </template>
                        </select>
                        @error('lecture_id')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div></div>
                    
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
                        <label class=" text-green-500" for="username">Answer (right)</label>
                        <div class="flex gap-4">
                            <input name="answer[]" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('answer')[0] ?? '' }}">
                        </div>
                    </div>

                    <div >
                        <label class=" text-red-600" for="username">Answer (wrong)</label>
                        <div class="flex gap-4">
                            <input name="answer[]" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('answer')[1] ?? '' }}" >
                        </div>
                    </div>


                    <div >
                        <label class=" text-red-600" for="username">Answer (wrong)</label>
                        <div class="flex gap-4">
                            <input name="answer[]" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('answer')[2] ?? '' }}">
                        </div>
                    </div>

                    <div >
                        <label class=" text-red-600" for="username">Answer (wrong)</label>
                        <div class="flex gap-4">
                            <input name="answer[]" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" type="text" value="{{ old('answer')[3] ?? '' }}">
                        </div>
                    </div>

                    <div >
                        <label class=" text-gray-700" for="username">Difficulty</label>
                        <select name="difficulty" class="form-input w-full rounded-md focus:border-indigo-600  mt-2">
                            <option {{ old('difficulty') == "easy" ? "selected": "" }}>easy</option>
                            <option {{ old('difficulty') == "medium" ? "selected": "" }}>medium</option>
                            <option {{ old('difficulty') == "hard" ? "selected": "" }}>hard</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-end mt-4 gap-4">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" >{{ app('language')['save'] }}</button>
                    <a href="{{ route('question.index', 'course_id='.($course->id ?? 0).'&lecture_id='.($lecture->id ?? 0)) }}" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['cancel'] }} </a>
                </div>

            </form>

        </div>
    </div>

@endsection