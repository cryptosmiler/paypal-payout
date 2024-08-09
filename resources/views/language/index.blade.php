@extends('_layouts.master')

@section('body')
    <div class="flex justify-between" x-data="{ type: '{{ request('type') }}' }">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['languages'] }} </h3>

        <select class="form-input w-40 rounded-md focus:border-indigo-600" x-model="type" @change="window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), 'type': type}).toString()}`;" >
            <option value="web"> Admin </option>
            <option value="app"> Student </option>
            <option value="message"> Messages </option>
        </select>
    </div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Key</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">English</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Hebrew</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Arabic</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        <form action="{{ route('language.index') }}" method="GET" >
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
                                        <input name="english" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('english') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="hebrew" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('hebrew') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <input name="arabic" class="form-input w-full rounded-md focus:border-indigo-600" type="text" value="{{ request('arabic') }}">
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2"></td>
                                
                            </tr>
                        </form>
                    </thead>

                    <tbody class="bg-white">
                        @foreach($languages as $language)
                            <tr>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $language->key }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $language->en }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $language->he }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $language->ar }}</td>


                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium ">
                                    <a href="{{ route('language.edit', $language->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ app('language')['edit'] }}</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection