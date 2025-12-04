<form action="{{ route($routeName) }}" method="GET" class="">
    @if (request('fiscal_year_id'))
        <select name="fiscal_year_id" class=" kalimati-font form-control border-0  font-14" onchange="this.form.submit()">
            @foreach ($fiscalYears as $fiscalYear)
                <option value="{{ $fiscalYear->id }}"  {{request('fiscal_year_id') == $fiscalYear->id ? 'selected' : ''}}>
                    {{ englishToNepaliLetters($fiscalYear->name) }}</option>
            @endforeach
        </select>
    @else
        <select name="fiscal_year_id" class=" kalimati-font form-control border-0  font-14" onchange="this.form.submit()">
            @foreach ($fiscalYears as $fiscalYear)
                <option value="{{ $fiscalYear->id }}" {{ $fiscalYear->is_running ? 'selected' : '' }}>
                    {{ englishToNepaliLetters($fiscalYear->name) }}</option>
            @endforeach
        </select>
    @endif
</form>
