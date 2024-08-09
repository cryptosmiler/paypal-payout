@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['teachers'] }} </h3>


    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Decrease</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('account.index') }}" method="GET">
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
                                        <input name="name" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('name') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="email" class="form-input w-48 rounded-md focus:border-indigo-600" type="text" value="{{ request('email') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="phone" class="form-input w-36 rounded-md focus:border-indigo-600" type="text" value="{{ request('phone') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="activated" class="form-input w-full rounded-md focus:border-indigo-600">
                                            <option value="">  </option>
                                            <option {{ request('activated') == "1" ? "selected": "" }} value="1"> Active </option>
                                            <option {{ request('activated') == "0" ? "selected": "" }} value="0"> Inactive </option>
                                        </select>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="role" class="form-input w-full rounded-md focus:border-indigo-600">
                                            <option {{ request('role') == "Teacher" ? "selected": "" }} value="Teacher"> Teacher </option>
                                        </select>
                                    </div>
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
                        @foreach($teachers as $teacher)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $i ++ }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $teacher->avatar }}" alt="" />
                                        </div>
    
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900">{{ $teacher->first_name . " " . $teacher->last_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $teacher->email }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ "+ ". $teacher->phone_prefix . " " . $teacher->phone }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    @if($teacher->activated == 1)
                                        <a class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" href="{{ route('account.active', ['account' => $teacher->id, 'state' => 0]) }}">Active</a>
                                    @else
                                        <a class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"href="{{ route('account.active', ['account' => $teacher->id, 'state' => 1]) }}">Inactive</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $teacher->role }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <form action="{{ route('account.update', $teacher->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-2" >
                                        @csrf
                                        {{method_field('PATCH')}}
                                        <input type="text" name="decrease" value="{{ $teacher->decrease }}" class="form-input w-16 rounded-md focus:border-indigo-600" />
                                        <button class="border rounded-md px-2 bg-green-600 text-white">  
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                    <a class="px-2 flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 gap-2 items-center justify-center" href="{{ route('teacherTransaction.create', ['teacher' => $teacher->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                        </svg>
                                          
                                        Transfer Money
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection