@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['logs'] }} </h3>


        <div class="flex gap-4" x-data="{ start: '{{ request('start') ?? '' }}', end: '{{ request('end') ?? '' }}', open_delete_all: false }">

            <div date-rangepicker="" id="dateRangePickerId" datepicker-orientation=" right bottom left" class="flex items-center underline">
                <input 
                    type="text" 
                    name="start" 
                    x-model="start"
                    class="rounded-lg datepicker" 
                    onchange=" onStartChanged(this) "
                />
                <span class="mx-4 text-gray-500">to</span>
                <input type="text" name="end" x-model="end" class="rounded-lg datepicker" onchange="onEndChanged(this)" />
            </div>

            

            <div class=" inline">
                <a
                    x-show="start !== '' && end !== ''"
                    type="button"
                    href="#"
                    @click="open_delete_all=true"
                    class="px-4 py-2 bg-red-900 text-gray-200 rounded-md hover:bg-red-800 focus:outline-none focus:bg-red-800 flex gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>

                    {{ app('language')['delete_all'] }}
                </a>

                <div x-show="open_delete_all" class="font-sans antialiased fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
                    <div x-show="open_delete_all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                
                    <div x-show="open_delete_all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Delete All
                                    </h3>
                                    <div class="mt-2">
                                    <p class="text-sm leading-5 text-gray-500">
                                        Are you sure you want to delete this logs?
                                    </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            
                                    <a 
                                        type="button" 
                                        class="delete_confirm inline-flex items-center px-4 py-2 bg-red-400 hover:bg-red-500 text-white text-sm font-medium rounded-md" 
                                        :href=" start !== '' && end !== '' ? '{{ route('log.deleteall') }}' + '?start=' + start + '&end=' + end : '#'"    
                                    >
                                        Delete
                                    </a>
                                
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button @click="open_delete_all = false;" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Cancel
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <a
                type="button"
                href="{{ route('log.export') }}"
                class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800 flex gap-2">
    
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                </svg>
    
                {{ app('language')['export'] }}
            </a>
        </div>
    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">role</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">name</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">email</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ip</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('log.index') }}" method="GET">
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="flex justify-center items-center">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 flex gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                            Search
                                        </button>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="level" class="form-input w-40 rounded-md focus:border-indigo-600" >
                                            <option ></option>
                                            <option {{ request('level') == "ALERT" ? "selected": '' }}> ALERT </option>
                                            <option {{ request('level') == "INFO" ? "selected": '' }}> INFO </option>
                                            <option {{ request('level') == "WARNING" ? "selected": '' }}> WARNING </option>
                                            <option {{ request('level') == "ERROR" ? "selected": '' }}> ERROR </option>
                                        </select>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="message" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('message') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <select name="role" class="form-input w-40 rounded-md focus:border-indigo-600" >
                                            <option ></option>
                                            <option {{ request('role') == "SuperAdmin" ? "selected": '' }}> SuperAdmin </option>
                                            <option {{ request('role') == "Admin" ? "selected": '' }}> Admin </option>
                                            <option {{ request('role') == "Teacher" ? "selected": '' }}> Teacher </option>
                                            <option {{ request('role') == "Student" ? "selected": '' }}> Student </option>
                                        </select>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="name" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('name') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="email" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('email') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="phone" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('phone') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-2 py-2"></td>
                                <td class="whitespace-nowrap px-2 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="ip" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('ip') }}">
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-2 py-2"></td>
                            </tr>
                        </form>
                    </thead>

                    <tbody class="bg-white">
                        @php
                            $i = (request('page') ?? 1) * 25 - 24;
                        @endphp
                        @foreach($logs as $log)
                        @php
                            $className = "";
                            if($log->level == "ALERT") $className = "bg-green-500";
                            else if ($log->level == "INFO") $className = "bg-blue-500";
                            else if ($log->level == "ERROR") $className = "bg-red-500";
                            else if ($log->level == "WARNING") $className = "bg-yellow-500";
                        @endphp
                            <tr class="{{ $className }} text-white">
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $i ++ }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->level }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->message }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->context['role'] ?? '' }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->context['name'] ?? '' }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->context['email'] ?? '' }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->context['phone'] ?? '' }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->context['time'] ?? '' }}</td>
                               <td class="px-2 py-1 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-nowrap">{{ $log->context['ip'] ?? '' }}</td>
                               <td class="px-2 py-1">
                                    <x-delete-modal 
                                        title="Delete Log"
                                        content="Are you sure you want to delete this log?"
                                        url="{{ route('log.destroy', $log->id) }}"
                                    />
                               </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
                <div class="p-2">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        var end = "{{ request('end') }}";
        var start = "{{ request('start') }}";

        function onStartChanged($event) {
            start = $event.value; 
 
            window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), 'start': start, 'end': end}).toString()}`;
        }

        function onEndChanged($event) {
            end = $event.value; 

            window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), 'start': start, 'end': end}).toString()}`;
        }
    </script>
@endsection