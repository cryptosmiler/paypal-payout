@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['courses'] }} </h3>

        <a
            type="button"
            href="{{ route('course.create') }}"
            class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800">
            <svg class="h-5 w-5 inline-block"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="5" y1="12" x2="19" y2="12" /></svg>
            {{ app('language')['add'] }}
        </a>
    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Coupon</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">visible</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price (Cent)</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lectures Count</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('course.index') }}" method="GET">
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
                                        <input name="title" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('title') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <select name="subject_id" class="form-input w-full rounded-md focus:border-indigo-600 pr-8 min-w-28">
                                        <option ></option>
                                        @foreach($subjects as $subject)
                                            <option {{ request('subject_id') == $subject->id ? "selected": "" }} value="{{ $subject->id }}" > {{ $subject->title }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="teacher" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('teacher') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="coupon" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('coupon') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <select name="visible" class="form-input w-full rounded-md focus:border-indigo-600 pr-8 min-w-24">
                                        <option></option>
                                        <option {{ request('visible') == "show" ? "selected": "" }} > show </option>
                                        <option {{ request('visible') == "hide" ? "selected": "" }} > hide </option>
                                    </select>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <select name="status" class="form-input w-full rounded-md focus:border-indigo-600 pr-8 min-w-28">
                                        <option ></option>
                                        <option value="created">exist</option>
                                        <option {{ request('status') == "deleted" ? "selected": "" }} > deleted </option>
                                    </select>
                                </td>

                                <td class="whitespace-nowrap px-4 py-2"></td>
                                <td class="whitespace-nowrap px-4 py-2"></td>
                            </tr>
                        </form>
                    </thead>

                    <tbody class="bg-white">
                        @php
                            $i = 1;
                        @endphp
                        @foreach($courses as $course)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <div class="flex items-center gap-2">
                                        {{ $i ++ }}
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $course->image }}" alt="" />
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 font-medium text-gray-900 text-nowrap">{{ $course->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $course->subject->title }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">{{ $course->admin->first_name . " " . $course->admin->last_name }}</td>

                                <td x-data="{ copied: false }" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <div class=" flex gap-2 justify-between">
                                        <span></span>
                                        {{ $course->coupon }}
                                        <svg x-show="!copied" @click="navigator.clipboard.writeText('{{ $course->coupon }}'); copied=true; setTimeout(function(){copied = false;}, 3000)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                        </svg> 
                                        <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#16A34A" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                          
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $course->visible }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">
                                    @if($course->charge == "pay")
                                        {{ "video : " . $course->video_price }}
                                        <br />
                                        {{ "question : " . $course->question_price }}
                                    @else 
                                    <span class=" bg-green-500 text-white text-xs font-semibold rounded-full px-2 py-1 flex items-center justify-center">
                                        {{ $course->charge }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 text-nowrap">{{ $course->min . " min " . $course->sec . " sec" }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $course->order }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    @if($course->status == "deleted")
                                        deleted
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <a href="{{ route('course.show', $course->id) }}" class="text-cyan-600">
                                        {{ "Lectures : ".$course->lectures_count }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium ">
                                    <a href="{{ route('course.edit', $course->id) }}" class="text-indigo-600 hover:text-indigo-900"> {{ app('language')['edit'] }} </a>
                                    <x-delete-modal 
                                        title="Delete Course"
                                        content="Are you sure you want to delete this course?"
                                        url="{{ route('course.destroy', $course->id) }}"
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