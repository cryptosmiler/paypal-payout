@extends('_layouts.master')

@section('body')
    <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['free_user'] }} </h3>

    <div class="mt-8">
        <div class="p-6 bg-white rounded-md shadow-md" >
            
            <form action="{{ route('freeUser.store') }}" method="POST" class="mt-4" enctype="multipart/form-data"  >
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4" x-data="{ subjectOption: '{{ $course->subject_id ?? 0 }}', courseOption: '{{ $course->id ?? 0 }}', lectureOption: '{{ $lecture->id ?? 0 }}', courseOptions: {{ $courses }}, lectureOptions: {{ $lectures }} }" >

                    <div >
                        <label class="text-gray-700" for="subject_id">Subject</label>
                        <select name="subject_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="subjectOption" >
                            @foreach ( $subjects as $subject )
                                <option value="{{ $subject->id }}" {{ $subject->id == old('subject_id') ? "selected": '' }}> {{ $subject->title }} </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div >
                        <label class="text-gray-700" for="course_id">Course</label>
                        <select name="course_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="courseOption" @change="console.log(courseOption)">
                            <option ></option>
                            <template x-for="course in courseOptions.filter((c) => c.subject_id == subjectOption )" :key="course.id">
                                <option x-text="course.title" :value="course.id" :selected="course.id == courseOption"></option>
                            </template>
                        </select>
                        @error('course_id')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div >
                        <label class="text-gray-700" for="lecture_id">Lecture</label>
                        <select name="lecture_id" class="form-input w-full rounded-md focus:border-indigo-600" x-model="lectureOption">
                            <template x-for="lecture in lectureOptions.filter((l) => l.course_id == courseOption)" :key="lecture.id">
                                <option x-text="lecture.title" :value="lecture.id" :selected="lecture.id == lectureOption"></option>
                            </template>
                        </select>
                        @error('lecture_id')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-700" for="username">Phone Number</label>
                        <input type="tel" id="phone" class="tel-input form-input mt-1 block w-full rounded-md focus:border-indigo-600" required="required" name="phone" value="{{ old("phone") }}">
                        <input type="hidden" name="phone_prefix" id="phone_prefix" value="{{ old("phone_prefix", "972") }}" />
                        <input type="hidden" name="country_code" id="country_code" value="{{ old("country_code", "IL") }}" />
                        @error('phone')
                            <span class=" text-red-600" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-4 gap-4">
                    <button class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" >{{ app('language')['save'] }}</button>
                    <a href="{{ route('freeUser.index', 'course_id='.($course->id ?? 0).'&lecture_id='.($lecture->id ?? 0)) }}" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700" > {{ app('language')['cancel'] }} </a>
                </div>

            </form>

        </div>
    </div>

    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/utils.js",
            initialCountry: 'IL', 
        });
    
    
        // store the instance variable so we can access it in the console e.g. window.iti.getNumber()
        window.iti = iti;
    
        input.addEventListener('countrychange', function() { 
            var countryData = iti.getSelectedCountryData();
            $("#country_code").val(countryData?.iso2?.toUpperCase());
            $("#phone_prefix").val(countryData?.dialCode);
        });
    </script>

@endsection

