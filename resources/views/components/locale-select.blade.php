<select name="locale" class="form-input w-full rounded-md focus:border-indigo-600">
    @if($isSearch)
    <option></option>
    @endif
    @foreach (Config::get('languages') as $lang => $language)
        <option {{ $sLocale == $lang ? "selected": "" }} value="{{ $lang }}"> {{ $language }} </option>
    @endforeach
</select>