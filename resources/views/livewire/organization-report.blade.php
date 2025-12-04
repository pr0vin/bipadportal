{{-- @if (request('diseaseType') == '2')
@include('partials.bipanna-tab')
@endif --}}
<div class="card z-depth-0 printableCard">
    <div class="card-body">
        {{-- <div class="blue lighten-5 p-3 notPrintable">
            @php
            $diseases = App\ApplicationType::find(request('diseaseType') ?? 1)->diseases;
            @endphp
            <x-organization-filter-bar :diseases="$diseases"></x-organization-filter-bar>
        </div> --}}
        <div class="d-flex justify-content-end mt-2 notPrintable">
            <div class="d-flex justify-content-end">
                <button type="button" class="bg-transparent border-0 mr-2" id="report_print"><i class="fa fa-print"
                        aria-hidden="true"></i>
                    Print</button>
                @php
                    $fullUrl = url()->full() . '&excel=1';
                @endphp
                <a href="{{ $fullUrl }}" class="bg-transparent border-0" style=""><i class="fa fa-file-excel"
                        aria-hidden="true"></i>
                    Excel</a>
            </div>
        </div>
        <div class="my-3"></div>
        <div id="printReport" class="m-0 p-0">
            <h1 style="font-size:20px" class="kalimati-font text-center">
                प्रकोपको सङख्या र क्षतिको विवरण
            </h1>

            <div class="py-4">
                <table class="table table-bordered table-sm kalimati-font">
                    <thead class="font-noto">
                        <tr class="text-center" style="font-size: 11px">
                            <th rowspan="2">क्र.स</th>
                            <th rowspan="2">घटनाको प्रकार</th>
                            <th rowspan="2">मृत्यु</th>
                            <th rowspan="2">वेपत्ता</th>
                            <th rowspan="2">घाईते</th>
                            <th rowspan="2">प्रभावित परिवार</th>
                            <th rowspan="2">हराएका र जलेका पशुचौपाया</th>
                            <th colspan="2">घरको क्षती</th>
                            <th rowspan="2">गोठ क्षति</th>
                            <th rowspan="2">अनुमानित क्षति रकम रु.</th>
                        </tr>

                        <tr class="text-center" style="font-size: 11px">
                            <th>पुर्ण</th>
                            <th>आंशिक</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($applicationTypeCounts as $index => $row)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->name }}</td>

                                <td>{{ $row->diseases->where('id', 1)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 2)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 3)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 4)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 5)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 6)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 7)->sum('patient_count') }}</td>
                                <td>{{ $row->diseases->where('id', 8)->sum('patient_count') }}</td>

                                <td>{{ $row->amount ?? 0 }}</td>
                            </tr>
                        @endforeach


                        @if($applicationTypeCounts->sum(fn($t) => $t->diseases->count()) == 0)

                            <tr>
                                <td colspan="11" class="text-center font-noto">
                                    कुनै पनि विवरण फेला परेन ।
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<div class="card mt-3 m-0 p-0">
    @push('scripts')
        <script>
            $(document).ready(function () {

                $("#report_print").click(() => {


                    window.print();


                })
            })
        </script>
    @endpush