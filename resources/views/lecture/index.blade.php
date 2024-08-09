@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['lectures'] }} </h3>

        <div class="flex flex-row items-center gap-4" x-data="{ course_id: '{{ request('course_id') }}' }">
            <select class="form-input w-40 rounded-md focus:border-indigo-600" x-model="course_id" @change="window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), 'course_id': course_id}).toString()}`;" >
                <option ></option>
                @foreach ( $courses as $course )
                    <option value="{{ $course->id }}" > {{ $course->title }} </option>
                @endforeach
            </select>

            <a
                x-show="!!course_id"
                type="button"
                :href="!!course_id ? '{{ route('lecture.create') }}' + '?course=' + course_id : '#'"
                class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800">
                <svg class="h-5 w-5 inline-block"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="5" y1="12" x2="19" y2="12" /></svg>
                {{ app('language')['add'] }}
            </a>
        </div>

    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200" x-data="{ subjectOption: '{{ request('subject') }}', courseOption: '{{ request('course') }}', courseOptions: {{ $courses }} }">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Size</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Question count</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Viwers</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('lecture.index') }}" method="GET" >
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
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="subject" class="form-input w-40 rounded-md focus:border-indigo-600" x-model="subjectOption" @change="console.log(subjectOption)">
                                            <option ></option>
                                            @foreach ( $subjects as $subject )
                                                <option value="{{ $subject->id }}" {{ $subject->id == old('subject') ? "selected": '' }}> {{ $subject->title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="course" class="form-input w-40 rounded-md focus:border-indigo-600" x-model="courseOption">
                                            <option ></option>
                                            <template x-for="course in courseOptions.filter((c) => c.subject_id == subjectOption)" :key="course.id">
                                                <option x-text="course.title" :value="course.id"></option>
                                            </template>
                                        </select>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="title" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('title') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="order" class="form-input w-full rounded-md focus:border-indigo-600" type="number" value="{{ request('order') }}" >
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-2"></td>
                                <td class="whitespace-nowrap px-4 py-2"></td>
                                <td class="whitespace-nowrap px-4 py-2"></td>
                            </tr>
                        </form>
                    </thead>

                    <tbody class="bg-white">
                        @php
                            $i = 1;
                        @endphp
                        @foreach($lectures as $lecture)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $i ++ }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">{{ $lecture->admin->first_name . " " . $lecture->admin->last_name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $lecture->subject->title }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $lecture->course->title }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $lecture->title }}</td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">
                                    {{ str_pad(floor($lecture->duration / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($lecture->duration % 60, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">{{ $lecture->size . " MB" }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $lecture->order }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <a class="text-cyan-600" href="{{ route('question.index', 'course_id='.$lecture->course_id."&lecture_id=".$lecture->id) }}">
                                        {{ "Questions: " . $lecture->questions_count }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">
                                    <a class="text-cyan-600" href="{{ route('question.index', 'course_id='.$lecture->course_id."&lecture_id=".$lecture->id) }}">
                                        {{ "Viwers: " . $lecture->transactions_count }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium text-nowrap">
                                    <a href="{{ route('lecture.edit', $lecture->id) }}" class="text-indigo-600 hover:text-indigo-900"> {{ app('language')['edit'] }} </a>
                                    <x-delete-modal 
                                        title="Delete Lecture"
                                        content="Are you sure you want to delete this lecture?"
                                        url="{{ route('lecture.destroy', $lecture->id) }}"
                                    />
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection