@extends('_layouts.master')

@section('body')
    <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['transfer_money'] }} </h3>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md">

            @if(session('success'))
                <div class=" text-green-500 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @error('teacher')
                <span class=" text-red-600" role="alert">
                    {{ $message }}
                </span>
            @enderror
            
            <form action="{{ route('teacherTransaction.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    <input type="hidden" name="admin_id" value="{{ request()->query('teacher') }}">
                    <div>
                        <label class="text-gray-700" >Available</label>
                        <input class="form-input w-full mt-2 rounded-md focus:border-none border-transparent outline-none border-none" type="number" readonly>
                    </div>

                    <div>
                        <label class="text-gray-700" for="amount">Amount (USD)</label>
                        <input type="number" name="amount" class="form-input w-full mt-2 rounded-md focus:border-indigo-600" value="{{ old('amount') }}" placeholder="10...">
                        @error('amount')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-4 gap-2">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['save'] }} </button>
                    <a href="{{ route('account.index') }}" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['cancel'] }} </a>
                </div>
            </form>
        </div>
    </div>


@endsection

