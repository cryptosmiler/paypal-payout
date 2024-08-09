@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['questions'] }} </h3>

        <div class="flex">
            <div class="flex flex-row items-center gap-4" x-data="{ course_id: '{{ request('course_id') ?? '' }}', lecture_id: '{{ request('lecture_id') ?? '' }}', lectureOptions: {{ $lectures }} }">
                <select class="form-input w-40 rounded-md focus:border-indigo-600" x-model="course_id" @change="window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), 'course_id': course_id, 'lecture_id': lecture_id}).toString()}`;" >
                    <option ></option>
                    @foreach ( $courses as $course )
                        <option value="{{ $course->id }}" > {{ $course->title }} </option>
                    @endforeach
                </select>

                <select class="form-input w-40 rounded-md focus:border-indigo-600" x-model="lecture_id" @change="window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), 'course_id': course_id, 'lecture_id': lecture_id}).toString()}`;" >
                    <option ></option>
                    <template x-for="lecture in lectureOptions.filter((c) => c.course_id == course_id)" :key="lecture.id">
                        <option x-text="lecture.title" :value="lecture.id" :selected="lecture.id == lecture_id"></option>
                    </template>
                </select>
    
                <a
                    x-show="course_id !== '' && lecture_id !== ''"
                    type="button"
                    :href="course_id !== '' && lecture_id !== '' ? '{{ route('question.create') }}' + '?course=' + course_id + '&lecture=' + lecture_id: '#'"
                    class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800">
                    <svg class="h-5 w-5 inline-block"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="5" y1="12" x2="19" y2="12" /></svg>
                    {{ app('language')['add'] }}
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200" x-data="{ subjectOption: '{{ request('subject') }}', courseOption: '{{ request('course') }}', lectureOption: '{{ request('lecture') }}', courseOptions: {{ $courses }}, lectureOptions: {{ $lectures }} }">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lecture</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Difficulty</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Question</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('question.index') }}" method="GET">
                            <input name="course_id" value="{{ request("course_id") }}" type="hidden" />
                            <input name="lecture_id" value="{{ request("lecture_id") }}" type="hidden" />
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="flex justify-center items-center">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 flex gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                            Search
                                        </button>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="teacher" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('teacher') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    {{-- <div class="relative rounded-md shadow-sm">
                                        <select name="subject" class="form-input w-40 rounded-md focus:border-indigo-600" x-model="subjectOption" @change="console.log(subjectOption)">
                                            <option ></option>
                                            @foreach ( $subjects as $subject )
                                                <option value="{{ $subject->id }}" {{ $subject->id == old('subject') ? "selected": '' }}> {{ $subject->title }} </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    {{-- <div class="relative rounded-md shadow-sm">
                                        <select name="course" class="form-input w-40 rounded-md focus:border-indigo-600" x-model="courseOption">
                                            <option ></option>
                                            <template x-for="course in courseOptions.filter((c) => c.subject_id == subjectOption)" :key="course.id">
                                                <option x-text="course.title" :value="course.id"></option>
                                            </template>
                                        </select>
                                    </div> --}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    {{-- <div class="relative rounded-md shadow-sm">
                                        <select name="lecture" class="form-input w-40 rounded-md focus:border-indigo-600" x-model="lectureOption">
                                            <option ></option>
                                            <template x-for="lecture in lectureOptions.filter((c) => c.course_id == courseOption)" :key="lecture.id">
                                                <option x-text="lecture.title" :value="course.id"></option>
                                            </template>
                                        </select>
                                    </div> --}}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="difficulty" class="form-input w-40 rounded-md focus:border-indigo-600" >
                                            <option ></option>
                                            <option {{ request('difficulty') == "easy" ? "selected": "" }}>easy</option>
                                            <option {{ request('difficulty') == "medium" ? "selected": "" }}>medium</option>
                                            <option {{ request('difficulty') == "hard" ? "selected": "" }}>hard</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="question" class="form-input w-full rounded-md focus:border-indigo-600" type="number" value="{{ request('question') }}" >
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">

                                </td>

                                <td class="whitespace-nowrap px-4 py-2">
                                </td>
                            </tr>
                        </form>
                    </thead>
    
                    <tbody class="bg-white">
                        @php
                            $i = 1;
                        @endphp
                        @foreach($questions as $question)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $i ++ }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">{{ $question->admin->first_name . " " . $question->admin->last_name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $question->subject->title }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $question->course->title }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $question->lecture->title }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                @if( $question->difficulty == "easy" )
                                <span class=" py-1 px-4 bg-green-600 text-white rounded-2xl">
                                @elseif( $question->difficulty == "medium" )
                                <span class=" py-1 px-4 bg-yellow-600 text-white rounded-2xl">
                                @elseif( $question->difficulty == "hard" )
                                <span class=" py-1 px-4 bg-red-600 text-white rounded-2xl">
                                @else
                                <span>
                                @endif
                                    {{ $question->difficulty }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $question->question }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                @foreach($question->answer as $key => $ans)
                                    @if($key == 0)
                                    <div class=" text-green-500">{{ $ans }}</div>
                                    @else
                                    <div class=" text-red-600" >{{ $ans }}</div>
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                @if( ($question->admin_id == auth()->guard('admin')->user()->id && $question->status == "created") || auth()->guard('admin')->user()->role == "Admin" || auth()->guard('admin')->user()->role == "SuperAdmin")
                                <a href="{{ route('question.edit', $question->id) }}" class="text-indigo-600 hover:text-indigo-900"> {{ app('language')['edit'] }} </a>

                                <x-delete-modal 
                                    title="Delete Question"
                                    content="Are you sure you want to delete this question?"
                                    url="{{ route('question.destroy', $question->id) }}"
                                />
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection