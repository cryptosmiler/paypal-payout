@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['analysis'] }} </h3>
    </div>

    <div class="gap-8 h-[calc(100vh_-_13rem)] overflow-scroll mt-8 p-4 bg-white rounded-lg whitespace-nowrap grid grid-cols-2" id="table_container" x-data="{ teacher: {{ request('teacher') ?? 0 }}, subject: {{ request('subject') ?? 0 }}, course: {{ request('course') ?? 0 }}, lecture: {{ request('lecture') ?? 0 }} }">

            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 h-[40vh] overflow-y-auto">
                <div class="text-gray-700 text-xl font-medium p-4"> {{ app('language')['teachers'] }} </div>
                <div class="align-middle min-w-full shadow sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @php
                                $i = 1;
                            @endphp
                            @foreach($teachers as $teacher)
                                <tr class="{{ (request('teacher') ?? 0) == $teacher->id ? '[&>td]:bg-teal-600 text-white': 'text-black' }} cursor-pointer" @click=" window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({'teacher': {{ $teacher->id }}}).toString()}`; ">
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200">{{ $i ++ }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="{{ $teacher->avatar }}" alt="" />
                                            </div>
        
                                            <div class="ml-4">
                                                <div class="text-sm leading-5 font-medium">{{ $teacher->first_name . " " . $teacher->last_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $teacher->email }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ "+ ". $teacher->phone_prefix . " " . $teacher->phone }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 h-[40vh] overflow-y-auto">
                <div class="text-gray-700 text-xl font-medium p-4"> {{ app('language')['lectures'] }} </div>
                <div class="align-middle min-w-full shadow sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @php
                                $i = 1;
                            @endphp
                            @foreach($lectures as $lecture)
                                <tr class="{{ (request('lecture') ?? 0) == $lecture->id ? '[&>td]:bg-teal-600 text-white': 'text-black' }} cursor-pointer" @click=" window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({ 'teacher': teacher, 'subject': subject, 'course': course,'lecture': {{ $lecture->id }}}).toString()}`; ">
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $i ++ }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $lecture->title }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-wrap">{{ $lecture->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 h-[40vh] overflow-y-auto">
                <div class="text-gray-700 text-xl font-medium p-4"> {{ app('language')['subjects'] }} </div>
                <div class="align-middle min-w-full shadow sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @php
                                $i = 1;
                            @endphp
                            @foreach($subjects as $subject)
                                <tr class="{{ (request('subject') ?? 0) == $subject->id ? '[&>td]:bg-teal-600 text-white': 'text-black' }} cursor-pointer" @click=" window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({'teacher': teacher, 'subject': {{ $subject->id }}}).toString()}`; ">
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center gap-4">
                                            {{ $i ++ }}

                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="{{ $subject->image }}" alt="" />
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $subject->title }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-wrap">{{ $subject->description }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 h-[40vh] overflow-y-auto">
                <div class="text-gray-700 text-xl font-medium p-4"> {{ app('language')['questions'] }} </div>
                <div class="align-middle min-w-full shadow sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @php
                                $i = 1;
                            @endphp
                            @foreach($questions as $question)
                                <tr >
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center gap-4">
                                            {{ $i ++ }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $question->question }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">
                                        @foreach(json_decode($question->answer) as $key => $ans)
                                            @if($key == 0)
                                            <div class=" text-green-500">{{ $ans }}</div>
                                            @else
                                            <div class=" text-red-600" >{{ $ans }}</div>
                                            @endif
                                        @endforeach
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 h-[40vh] overflow-y-auto">
                <div class="text-gray-700 text-xl font-medium p-4"> {{ app('language')['courses'] }} </div>
                <div class="align-middle min-w-full shadow sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Coupon</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @php
                                $i = 1;
                            @endphp
                            @foreach($courses as $course)
                                <tr class="{{ (request('course') ?? 0) == $course->id ? '[&>td]:bg-teal-600 text-white': 'text-black' }} cursor-pointer" @click=" window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({ 'teacher': teacher, 'subject': subject, 'course': {{ $course->id }}}).toString()}`; ">
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center gap-4">
                                            {{ $i ++ }}

                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="{{ $course->image }}" alt="" />
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $course->title }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-wrap">{{ $course->description }}</td>
                                    <td class="px-6 py-2 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">{{ $course->coupon }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

    </div>

    <script>
        $(document).ready(function() {
           $('#table_container').animate({scrollLeft: $("#table_container ul").width()},"fast");
        })
    </script>
@endsection