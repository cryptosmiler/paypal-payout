@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['free_users'] }} </h3>

        <a
            type="button"
            href="{{ route('freeUser.create') }}"
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
                            @if( auth()->guard('admin')->user()->role === "SuperAdmin" || auth()->guard('admin')->user()->role === "Admin" )
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            @endif
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lecture</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Users counts</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Excel</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @foreach($freeUsers as $freeUser)
                            <tr>
                                @if( auth()->guard('admin')->user()->role === "SuperAdmin" || auth()->guard('admin')->user()->role === "Admin" )
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $freeUser->teacher->first_name . " " . $freeUser->teacher->last_name }}</td>
                                @endif

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $freeUser->subject->title }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $freeUser->course->title }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $freeUser->lecture->title }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <a href="{{ route('freeUser.show', $freeUser->id) }}" class="text-indigo-600 hover:text-indigo-900"> {{ $freeUser->counts . " " . app('language')['free_users'] }} </a>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">

                                    <form action="{{ route('freeUser.excelUpload') }}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                        <input type="hidden" name="subject_id" value="{{ $freeUser->subject_id }}" >
                                        <input type="hidden" name="course_id" value="{{ $freeUser->course_id }}" >
                                        <input type="hidden" name="lecture_id" value="{{ $freeUser->lecture_id }}" >
                                        <input type="file" name="excel_file" class=" hidden" accept=".xlsx, .xls">
                                        <button type="button" name="upload_excel" class=" text-blue-600 underline">Upload Excel</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection