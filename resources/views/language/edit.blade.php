@extends('_layouts.master')

@section('body')
    <h3 class="text-gray-700 text-3xl font-medium">{{ app('language')['edit_language'] }}</h3>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">

            <form action="{{ route('language.update', $language->id) }}" method="POST" class="mt-4" enctype="multipart/form-data" >
                @csrf
                {{method_field('PATCH')}}

                <div class="grid grid-cols-1  gap-6 mt-4">

                    <div>
                        <label class="text-gray-700" for="emailAddress">Key</label>
                        <input name="key" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" value="{{ old('key', $language->key) }}" readonly>
                        @error('key')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">English</label>
                        <textarea name="en" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" rows="4">{{ old('en', $language->en) }}</textarea>
                        @error('en')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Hebrew</label>
                        <textarea name="he" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" rows="4">{{ old('he', $language->he) }}</textarea>
                        @error('he')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Arabic</label>
                        <textarea name="ar" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" rows="4">{{ old('ar', $language->ar) }}</textarea>
                        @error('ar')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-4">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['save'] }} </button>
                </div>
            </form>
        </div>
    </div>


@endsection

