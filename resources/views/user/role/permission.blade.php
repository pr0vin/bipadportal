@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container-fluid main-container" style="overflow: hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="card z-depth-0">
                    <div class="card-header bg-white">
                        <h5 class="m-0 p-0 font-weight-bold">{{ $role->name }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('role.permissionSync',$role->id)}}" method="POST">
                            @csrf
                            @method('put')

                        <table class="permission_table" style="width: 100%">
                            <tr>
                                <td class="font-weight-bold">नयाँ आवेदन</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.create"
                                            id="dirghaCreate" {{$role->hasDirectPermission('dirgha.create') ? 'checked' : ''}}>
                                        <label class="form-check-label" for="dirghaCreate">
                                            दीर्घरोगी मासिक उपचार खर्च
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.create" {{$role->hasDirectPermission('bipanna.create') ? 'checked' : ''}}
                                            id="bipannaCreate">
                                        <label class="form-check-label" for="bipannaCreate">
                                            बिपन्न सहयोगको सिफारिस
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.create" {{$role->hasDirectPermission('samajik.create') ? 'checked' : ''}}
                                            id="samajikCreate">
                                        <label class="form-check-label" for="samajikCreate">
                                            सामाजिक विकास मन्त्रालय
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.create" {{$role->hasDirectPermission('nagarpalika.create') ? 'checked' : ''}}
                                            id="nagarpalikaCreate">
                                        <label class="form-check-label" for="nagarpalikaCreate">
                                            पालिकाको स्वास्थ्य राहत कोष
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">आवेदन फारामहरु</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.application" {{$role->hasDirectPermission('dirgha.application') ? 'checked' : ''}}
                                            id="dirghaapplication">
                                        <label class="form-check-label" for="dirghaapplication">
                                            दीर्घरोगी मासिक उपचार खर्च
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.application" {{$role->hasDirectPermission('bipanna.application') ? 'checked' : ''}}
                                            id="bipannaapplication">
                                        <label class="form-check-label" for="bipannaapplication">
                                            बिपन्न सहयोगको सिफारिस
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.application" {{$role->hasDirectPermission('samajik.application') ? 'checked' : ''}}
                                            id="samajikapplication">
                                        <label class="form-check-label" for="samajikapplication">
                                            सामाजिक विकास मन्त्रालय
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.application" {{$role->hasDirectPermission('nagarpalika.application') ? 'checked' : ''}}
                                            id="nagarpalikaapplication">
                                        <label class="form-check-label" for="nagarpalikaapplication">
                                            पालिकाको स्वास्थ्य राहत कोष
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">दर्ता/सिफारिस भएका</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.registered" {{$role->hasDirectPermission('dirgha.registered') ? 'checked' : ''}}
                                            id="dirgharegistered">
                                        <label class="form-check-label" for="dirgharegistered">
                                            दीर्घरोगी मासिक उपचार खर्च
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.registered" {{$role->hasDirectPermission('bipanna.registered') ? 'checked' : ''}}
                                            id="bipannaregistered">
                                        <label class="form-check-label" for="bipannaregistered">
                                            बिपन्न सहयोगको सिफारिस
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.registered" {{$role->hasDirectPermission('samajik.registered') ? 'checked' : ''}}
                                            id="samajikregistered">
                                        <label class="form-check-label" for="samajikregistered">
                                            सामाजिक विकास मन्त्रालय
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.registered" {{$role->hasDirectPermission('nagarpalika.registered') ? 'checked' : ''}}
                                            id="nagarpalikaregistered">
                                        <label class="form-check-label" for="nagarpalikaregistered">
                                            पालिकाको स्वास्थ्य राहत कोष
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">दीर्घरोगी मासिक उपचार खर्च</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.show" {{$role->hasDirectPermission('dirgha.show') ? 'checked' : ''}}
                                            id="dirghaShow">
                                        <label class="form-check-label" for="dirghaShow">
                                            हेर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.edit" {{$role->hasDirectPermission('dirgha.edit') ? 'checked' : ''}}
                                            id="dirghaedit">
                                        <label class="form-check-label" for="dirghaedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.delete" {{$role->hasDirectPermission('dirgha.delete') ? 'checked' : ''}}
                                            id="dirghadelete">
                                        <label class="form-check-label" for="dirghadelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.register" {{$role->hasDirectPermission('dirgha.register') ? 'checked' : ''}}
                                            id="dirgharegister">
                                        <label class="form-check-label" for="dirgharegister">
                                            दर्ता गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.tokenletter" {{$role->hasDirectPermission('dirgha.tokenletter') ? 'checked' : ''}}
                                            id="dirghaTokenLetter">
                                        <label class="form-check-label" for="dirghaTokenLetter">
                                            टोकन पत्र प्रिन्ट
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.renew" {{$role->hasDirectPermission('dirgha.renew') ? 'checked' : ''}}
                                            id="dirghaRenew">
                                        <label class="form-check-label" for="dirghaRenew">
                                            नवीकरण गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.close" {{$role->hasDirectPermission('dirgha.close') ? 'checked' : ''}}
                                            id="dirghaclose">
                                        <label class="form-check-label" for="dirghaclose">
                                            लगतकट्टा गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">बिपन्न सहयोगको सिफारिस </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.show" {{$role->hasDirectPermission('bipanna.show') ? 'checked' : ''}}
                                            id="bipannashow">
                                        <label class="form-check-label" for="bipannashow">
                                            हेर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.edit" {{$role->hasDirectPermission('bipanna.edit') ? 'checked' : ''}}
                                            id="bipannaedit">
                                        <label class="form-check-label" for="bipannaedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.delete" {{$role->hasDirectPermission('bipanna.delete') ? 'checked' : ''}}
                                            id="delete">
                                        <label class="form-check-label" for="delete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.register" {{$role->hasDirectPermission('bipanna.register') ? 'checked' : ''}}
                                            id="bipannaregister">
                                        <label class="form-check-label" for="bipannaregister">
                                            सिफारिस गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.TokenLetter" {{$role->hasDirectPermission('bipanna.TokenLetter') ? 'checked' : ''}}
                                            id="bipannaTokenLetter">
                                        <label class="form-check-label" for="bipannaTokenLetter">
                                            टोकन पत्र प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.DecisionPrint" {{$role->hasDirectPermission('bipanna.DecisionPrint') ? 'checked' : ''}}
                                            id="bipannaDecisionPrint">
                                        <label class="form-check-label" for="bipannaDecisionPrint">
                                            बिपन्न निर्णय प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.SifarisPrint" {{$role->hasDirectPermission('bipanna.SifarisPrint') ? 'checked' : ''}}
                                            id="bipannaSifarisPrint">
                                        <label class="form-check-label" for="bipannaSifarisPrint">
                                            सिफारिस पत्र प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold"> सामाजिक विकास मन्त्रालय </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.show" {{$role->hasDirectPermission('samajik.show') ? 'checked' : ''}}
                                            id="samajikshow">
                                        <label class="form-check-label" for="samajikshow">
                                            हेर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.edit" {{$role->hasDirectPermission('samajik.edit') ? 'checked' : ''}}
                                            id="samajikedit">
                                        <label class="form-check-label" for="samajikedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.delete" {{$role->hasDirectPermission('samajik.delete') ? 'checked' : ''}}
                                            id="samajikdelete">
                                        <label class="form-check-label" for="samajikdelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.register" {{$role->hasDirectPermission('samajik.register') ? 'checked' : ''}}
                                            id="samajikregister">
                                        <label class="form-check-label" for="samajikregister">
                                            सिफारिस गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.TokenLetter" {{$role->hasDirectPermission('samajik.TokenLetter') ? 'checked' : ''}}
                                            id="samajikTokenLetter">
                                        <label class="form-check-label" for="samajikTokenLetter">
                                            टोकन पत्र प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.DecisionPrint" {{$role->hasDirectPermission('samajik.DecisionPrint') ? 'checked' : ''}}
                                            id="samajikDecisionPrint">
                                        <label class="form-check-label" for="samajikDecisionPrint">
                                            निर्णय प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">पालिकाको स्वास्थ्य राहत कोष </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.show" {{$role->hasDirectPermission('nagarpalika.show') ? 'checked' : ''}}
                                            id="nagarpalikashow">
                                        <label class="form-check-label" for="nagarpalikashow">
                                            हेर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.edit" {{$role->hasDirectPermission('nagarpalika.edit') ? 'checked' : ''}}
                                            id="nagarpalikaedit">
                                        <label class="form-check-label" for="nagarpalikaedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.delete" {{$role->hasDirectPermission('nagarpalika.delete') ? 'checked' : ''}}
                                            id="nagarpalikadelete">
                                        <label class="form-check-label" for="nagarpalikadelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.register" {{$role->hasDirectPermission('nagarpalika.register') ? 'checked' : ''}}
                                            id="nagarpalikaregister">
                                        <label class="form-check-label" for="nagarpalikaregister">
                                            सिफारिस गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.TokenLetter" {{$role->hasDirectPermission('nagarpalika.TokenLetter') ? 'checked' : ''}}
                                            id="nagarpalikaTokenLetter">
                                        <label class="form-check-label" for="nagarpalikaTokenLetter">
                                            टोकन पत्र प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.DecisionPrint" {{$role->hasDirectPermission('nagarpalika.DecisionPrint') ? 'checked' : ''}}
                                            id="nagarpalikaDecisionPrint">
                                        <label class="form-check-label" for="nagarpalikaDecisionPrint">
                                            निर्णय प्रिन्ट गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">रिपोर्ट </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="dirgha.report" {{$role->hasDirectPermission('dirgha.report') ? 'checked' : ''}}
                                            id="dirghareport">
                                        <label class="form-check-label" for="dirghareport">
                                            दीर्घरोगी मासिक उपचार खर्च
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bipanna.report" {{$role->hasDirectPermission('bipanna.report') ? 'checked' : ''}}
                                            id="bipannareport">
                                        <label class="form-check-label" for="bipannareport">
                                            बिपन्न सहयोगको सिफारिस
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="samajik.report" {{$role->hasDirectPermission('samajik.report') ? 'checked' : ''}}
                                            id="samajikreport">
                                        <label class="form-check-label" for="samajikreport">
                                            सामाजिक विकास मन्त्रालय
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="nagarpalika.report" {{$role->hasDirectPermission('nagarpalika.report') ? 'checked' : ''}}
                                            id="nagarpalikareport">
                                        <label class="form-check-label" for="nagarpalikareport">
                                            पालिकाको स्वास्थ्य राहत कोष
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="closed.report" {{$role->hasDirectPermission('closed.report') ? 'checked' : ''}}
                                            id="closedreport">
                                        <label class="form-check-label" for="closedreport">
                                            लागतकट्टा भएका
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="renewed.report" {{$role->hasDirectPermission('renewed.report') ? 'checked' : ''}}
                                            id="renewedreport">
                                        <label class="form-check-label" for="renewedreport">
                                            नाविकरण भएका
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="notRenewed.report" {{$role->hasDirectPermission('notRenewed.report') ? 'checked' : ''}}
                                            id="notRenewedreport">
                                        <label class="form-check-label" for="notRenewedreport">
                                            नाविकरण नभएका
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">प्रयोगकर्ताहरू</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="user.store" {{$role->hasDirectPermission('user.store') ? 'checked' : ''}}
                                            id="userstore">
                                        <label class="form-check-label" for="userstore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="user.edit" {{$role->hasDirectPermission('user.edit') ? 'checked' : ''}}
                                            id="useredit">
                                        <label class="form-check-label" for="useredit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="user.delete" {{$role->hasDirectPermission('user.delete') ? 'checked' : ''}}
                                            id="userdelete">
                                        <label class="form-check-label" for="userdelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="user.password" {{$role->hasDirectPermission('user.password') ? 'checked' : ''}}
                                            id="userpassword">
                                        <label class="form-check-label" for="userpassword">
                                            पासवर्ड परिवर्तन गर्न
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">भूमिका (Role)</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="role.store" {{$role->hasDirectPermission('role.store') ? 'checked' : ''}}
                                            id="rolestore">
                                        <label class="form-check-label" for="rolestore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="role.edit" {{$role->hasDirectPermission('role.edit') ? 'checked' : ''}}
                                            id="roleedit">
                                        <label class="form-check-label" for="roleedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="role.delete" {{$role->hasDirectPermission('role.delete') ? 'checked' : ''}}
                                            id="roledelete">
                                        <label class="form-check-label" for="roledelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="role.permission" {{$role->hasDirectPermission('role.permission') ? 'checked' : ''}}
                                            id="rolepermission">
                                        <label class="form-check-label" for="rolepermission">
                                            अनुमति (Permission)
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">सेटिङ्</td>
                                {{-- <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="system.setting" {{$role->hasDirectPermission('system.setting') ? 'checked' : ''}}
                                            id="systemsetting">
                                        <label class="form-check-label" for="systemsetting">
                                            प्रणाली सेटिङ
                                        </label>
                                    </div>
                                </td> --}}
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="application.setting" {{$role->hasDirectPermission('application.setting') ? 'checked' : ''}}
                                            id="applicationsetting">
                                        <label class="form-check-label" for="applicationsetting">
                                            आवेदन सेटिङ
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="downloadDocument.setting" {{$role->hasDirectPermission('downloadDocument.setting') ? 'checked' : ''}}
                                            id="downloadDocumentsetting">
                                        <label class="form-check-label" for="downloadDocumentsetting">
                                            डाउनलोड योग्य कागजात
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="colsedReason.setting" {{$role->hasDirectPermission('colsedReason.setting') ? 'checked' : ''}}
                                            id="colsedReasonsetting">
                                        <label class="form-check-label" for="colsedReasonsetting">
                                            लागतकट्टाका कारणहरु
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="position.setting" {{$role->hasDirectPermission('position.setting') ? 'checked' : ''}}
                                            id="positionsetting">
                                        <label class="form-check-label" for="positionsetting">
                                            पद
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>

                                <td colspan="4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="committeePosition.setting" {{$role->hasDirectPermission('committeePosition.setting') ? 'checked' : ''}}
                                            id="committeePositionsetting">
                                        <label class="form-check-label" for="committeePositionsetting">
                                            समितिको पद
                                        </label>
                                    </div>
                                </td>
                                {{-- <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="sms.setting" {{$role->hasDirectPermission('sms.setting') ? 'checked' : ''}}
                                            id="smasetting">
                                        <label class="form-check-label" for="smasetting">
                                            SMS
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="onesignal.setting" {{$role->hasDirectPermission('onesignal.setting') ? 'checked' : ''}}
                                            id="onesignalsetting">
                                        <label class="form-check-label" for="onesignalsetting">
                                            Onesignal
                                        </label>
                                    </div>
                                </td> --}}
                            </tr>
                            <tr>
                                <td class="font-weight-bold">नयाँ पालिका</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="newPalika.store" {{$role->hasDirectPermission('newPalika.store') ? 'checked' : ''}}
                                            id="newPalikastore">
                                        <label class="form-check-label" for="newPalikastore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="newPalika.edit" {{$role->hasDirectPermission('newPalika.edit') ? 'checked' : ''}}
                                            id="newPalikaedit">
                                        <label class="form-check-label" for="newPalikaedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="newPalika.delete" {{$role->hasDirectPermission('newPalika.delete') ? 'checked' : ''}}
                                            id="newPalikadelete">
                                        <label class="form-check-label" for="newPalikadelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">आर्थिक वर्ष</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="fiscalYear.store" {{$role->hasDirectPermission('fiscalYear.store') ? 'checked' : ''}}
                                            id="fiscalYearstore">
                                        <label class="form-check-label" for="fiscalYearstore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="fiscalYear.edit" {{$role->hasDirectPermission('fiscalYear.edit') ? 'checked' : ''}}
                                            id="fiscalYearedit">
                                        <label class="form-check-label" for="fiscalYearedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="fiscalYear.delete" {{$role->hasDirectPermission('fiscalYear.delete') ? 'checked' : ''}}
                                            id="fiscalYeardelete">
                                        <label class="form-check-label" for="fiscalYeardelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">राेग</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="disease.store" {{$role->hasDirectPermission('disease.store') ? 'checked' : ''}}
                                            id="diseasestore">
                                        <label class="form-check-label" for="diseasestore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="disease.edit" {{$role->hasDirectPermission('disease.edit') ? 'checked' : ''}}
                                            id="diseaseedit">
                                        <label class="form-check-label" for="diseaseedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="disease.delete" {{$role->hasDirectPermission('disease.delete') ? 'checked' : ''}}
                                            id="diseasedelete">
                                        <label class="form-check-label" for="diseasedelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">अस्पताल</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="hospital.store" {{$role->hasDirectPermission('hospital.store') ? 'checked' : ''}}
                                            id="hospitalstore">
                                        <label class="form-check-label" for="hospitalstore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="hospital.edit" {{$role->hasDirectPermission('hospital.edit') ? 'checked' : ''}}
                                            id="hospitaledit">
                                        <label class="form-check-label" for="hospitaledit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="hospital.delete" {{$role->hasDirectPermission('hospital.delete') ? 'checked' : ''}}
                                            id="hospitaldelete">
                                        <label class="form-check-label" for="hospitaldelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">समिति</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="committee.store" {{$role->hasDirectPermission('committee.store') ? 'checked' : ''}}
                                            id="committeestore">
                                        <label class="form-check-label" for="committeestore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="committee.edit" {{$role->hasDirectPermission('committee.edit') ? 'checked' : ''}}
                                            id="committeeedit">
                                        <label class="form-check-label" for="committeeedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="committee.delete" {{$role->hasDirectPermission('committee.delete') ? 'checked' : ''}}
                                            id="committeedelete">
                                        <label class="form-check-label" for="committeedelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">सदस्य</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="member.store" {{$role->hasDirectPermission('member.store') ? 'checked' : ''}}
                                            id="memberstore">
                                        <label class="form-check-label" for="memberstore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="member.edit" {{$role->hasDirectPermission('member.edit') ? 'checked' : ''}}
                                            id="memberedit">
                                        <label class="form-check-label" for="memberedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="member.delete" {{$role->hasDirectPermission('member.delete') ? 'checked' : ''}}
                                            id="memberdelete">
                                        <label class="form-check-label" for="memberdelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td class="font-weight-bold">वडा नम्बर</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="ward.store" {{$role->hasDirectPermission('ward.store') ? 'checked' : ''}}
                                            id="wardstore">
                                        <label class="form-check-label" for="wardstore">
                                            थप्न
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="ward.edit" {{$role->hasDirectPermission('ward.edit') ? 'checked' : ''}}
                                            id="wardedit">
                                        <label class="form-check-label" for="wardedit">
                                            सम्पादन गर्न
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="ward.delete" {{$role->hasDirectPermission('ward.delete') ? 'checked' : ''}}
                                            id="warddelete">
                                        <label class="form-check-label" for="warddelete">
                                            हटाउन
                                        </label>
                                    </div>
                                </td>
                            </tr> --}}
                            <tr>
                                <td class="font-weight-bold">कागजात अपलोड </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="hospital_document" {{$role->hasDirectPermission('hospital_document') ? 'checked' : ''}}
                                            id="hospital_document">
                                        <label class="form-check-label" for="hospital_document">
                                            अस्पतालको पुर्जाको फोटोकपी
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="disease_proved_document" {{$role->hasDirectPermission('disease_proved_document') ? 'checked' : ''}}
                                            id="disease_proved_document">
                                        <label class="form-check-label" for="disease_proved_document">
                                            रोग प्रमाणित कागजात
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="citizenship_card" {{$role->hasDirectPermission('citizenship_card') ? 'checked' : ''}}
                                            id="citizenship_card">
                                        <label class="form-check-label" for="citizenship_card">
                                            नागरिकता/ जन्मदर्ता / बसाइसराई कागजात / राष्ट्रिय परिचय पत्र
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="application" {{$role->hasDirectPermission('application') ? 'checked' : ''}}
                                            id="application">
                                        <label class="form-check-label" for="application">
                                            अनुसूची २ बमोजिमको निबेदन
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="doctor_recomandation" {{$role->hasDirectPermission('doctor_recomandation') ? 'checked' : ''}}
                                            id="doctor_recomandation">
                                        <label class="form-check-label" for="doctor_recomandation">
                                            अनुसूची १ डाक्टरको सिफारिस
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="bank_cheque" {{$role->hasDirectPermission('bank_cheque') ? 'checked' : ''}}
                                            id="bank_cheque">
                                        <label class="form-check-label" for="bank_cheque">
                                            बैंक चेक बुक
                                        </label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="decision_document" {{$role->hasDirectPermission('decision_document') ? 'checked' : ''}}
                                            id="decision_document">
                                        <label class="form-check-label" for="decision_document">
                                            निर्णय
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-info">सेभ गर्नुहोस</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
