@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['subjects'] }} </h3>

        <a
            type="button"
            href="{{ route('subject.create') }}"
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
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            @if( auth()->guard('admin')->user()->role != 'Teacher' )
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            @endif
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Language</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('subject.index') }}" method="GET">
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
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="description" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('description') }}">
                                    </div>
                                </td>
                                @if( auth()->guard('admin')->user()->role != 'Teacher' )
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="teacher" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('teacher') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="created_at" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('created_at') }}">
                                    </div>
                                </td>
                                @endif
                                <td class="whitespace-nowrap px-4 py-2">
                                    <x-locale-select sLocale="{{ request('locale') }}" :isSearch="true" />
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
                        @foreach($subjects as $subject)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $i ++ }}</td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $subject->image }}" alt="" />
                                        </div>

                                        <div >
                                            <div class="text-sm leading-5 font-medium text-gray-900">{{ $subject->title }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $subject->description }}</td>
                                @if( auth()->guard('admin')->user()->role != 'Teacher' )
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $subject->admin->first_name . " " . $subject->admin->last_name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $subject->created_at }}</td>
                                @endif
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ Config::get('languages')[$subject->locale] }}</td>

                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium ">
                                    <a href="{{ route('subject.edit', $subject->id) }}" class="text-indigo-600 hover:text-indigo-900"> {{ app('language')['edit'] }} </a>
                                    <x-delete-modal 
                                        title="Delete Subject"
                                        content="Are you sure you want to delete this subject?"
                                        url="{{ route('subject.destroy', $subject->id) }}"
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