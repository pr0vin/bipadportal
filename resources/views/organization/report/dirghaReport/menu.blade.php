
<div class="d-flex mb-3 notPrintable">
    <a href="{{route('organization.report.dirghaReport')}}?diseaseType=1&ward={{session()->get('ward_number')}}" style="background-color: #e3e9ed" class="btn z-depth-0 {{\Request::route()->getName() == 'organization.report.dirghaReport' ? 'btn-info' : ''}}">त्रैमासिक रिपोर्ट</a>
    <a href="{{route('organization.report.index')}}?diseaseType=1" style="background-color: #e3e9ed" class="btn z-depth-0 {{\Request::route()->getName() == 'organization.report.index' ? 'btn-info' : ''}}">बार्षिक रिपोर्ट</a>
</div>
