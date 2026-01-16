<?php

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DecisionController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\LetterPadController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\PatientDoctorController;
use App\Http\Controllers\OnesignaltokenController;
use App\Http\Controllers\ApplicationTypeController;
use App\Http\Controllers\ApplicationTypesController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\CommitteePositionController;
use App\Http\Controllers\DiseasesController;
use App\Http\Controllers\SifarishController;
use App\Http\Controllers\PaymentsController;

Auth::routes(['register' => false]);
// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/registration', 'FrontendController@index')->name('organization.new');
Route::post('/check-organization-name', 'FrontendController@checkOrganizationName')->name('check-organization-name');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('language/{locale}', 'LanguageController@setLocale')->name('locale');

Route::get('/', [FrontendController::class, 'home'])->name('frontent.home');
Route::get('/apply', [FrontendController::class, 'apply'])->name('frontent.apply');
Route::get('/token-search', [FrontendController::class, 'tokenSearch'])->name('frontent.tokenSearch');



Route::get('test', function () {
    return ad_to_bs(now()->format('Y-m-d'));
});
Route::resources([
    'user' => 'UserController',
    'province' => 'ProvinceController',
    'district' => 'DistrictController',
    'municipality' => 'MunicipalityController',
    'ward' => 'WardController',
    'organization-type' => 'OrganizationTypeController'
]);

Route::get('unrenewed', 'OrganizationController@unrenewedList')->name('organization.unrenewed.index');

Route::get('fiscal-year/{fiscalYear?}', 'FiscalYearController@index')->name('fiscal-year.index');
Route::post('fiscal-year', 'FiscalYearController@store')->name('fiscal-year.store');
Route::put('fiscal-year/{fiscalYear}', 'FiscalYearController@update')->name('fiscal-year.update');
Route::delete('fiscal-year/{fiscalYear}', 'FiscalYearController@destroy')->name('fiscal-year.destroy');

Route::patch('organization/{id}/restore', 'OrganizationController@restore')->name('organization.restore');
// Route::resource('patient', 'OrganizationController');
Route::resource('organization', 'OrganizationController');
Route::get('organization/edit/{organization}', [OrganizationCOntroller::class, 'orgEdit'])->name('orgEdit');
Route::put('organization/update/{organization}', [OrganizationCOntroller::class, 'orgUpdate'])->name('orgUpdate');
Route::delete('organization/delete/{organization}', [OrganizationCOntroller::class, 'orgDelete'])->name('orgDelete');
Route::get('patient/{patient}/show', [OrganizationController::class, 'show'])->name('patient.show');
Route::get('patient/{patient}/edit', [OrganizationController::class, 'edit'])->name('patient.edit');
Route::delete('document', 'DocumentController@destroy')->name('ajax.document.destroy');

Route::get('organization/verify/{organization}', 'OrganizationActionController@verifyForm')->name('organization.verify.form');
Route::put('organization/verify/{organization}', 'OrganizationActionController@verify')->name('organization.verify');
Route::get('organization/register/{organization}', 'OrganizationActionController@registerForm')->name('organization.register.form');
Route::put('organization/register/{organization}', 'OrganizationActionController@register')->name('organization.register');
Route::get('organization/renew/{organization}', 'OrganizationActionController@renewForm')->name('organization.renew.form');
Route::put('organization/renew/{organization}', 'OrganizationActionController@renew')->name('organization.renew');
Route::get('organization/close/{organization}', 'OrganizationActionController@closeForm')->name('organization.close.form');
Route::put('organization/close/{organization}', 'OrganizationActionController@close')->name('organization.close');
Route::get('organization/rename/{organization}', 'OrganizationActionController@renameForm')->name('organization.rename.form');
Route::put('organization/rename/{organization}', 'OrganizationActionController@rename')->name('organization.rename');

Route::patch('rename-organization-type', 'OrganizationTypeController@renameExisting')->name('rename-organization-type');

Route::get('organizations/{organization}/subsidiary/create', 'SubsidiaryController@create')->name('subsidiary.create');
Route::post('organizations/{organization}/subsidiary', 'SubsidiaryController@store')->name('subsidiary.store');
Route::get('subsidiaries/{subsidiary}/edit', 'SubsidiaryController@edit')->name('subsidiary.edit');
Route::put('subsidiaries/{subsidiary}', 'SubsidiaryController@update')->name('subsidiary.update');
Route::delete('subsidiaries/{subsidiary}', 'SubsidiaryController@destroy')->name('subsidiary.destroy');

// Naamsari
Route::get('naamsari/{organization}', 'NaamsariController@index')->name('naamsari.index');
Route::post('naamsari/{organization}', 'NaamsariController@store')->name('naamsari.store');

// Karobar Paribartan
Route::get('karobar-paribartan/{organization}', 'KarobarParibartanController@index')->name('karobar-paribartan.index');
Route::post('karobar-paribartan/{organization}', 'KarobarParibartanController@store')->name('karobar-paribartan.store');

Route::get('report', 'OrganizationReportController@index')->name('organization.report.index');
Route::get('dirgha-report', 'OrganizationReportController@dirghaReport')->name('organization.report.dirghaReport');
Route::post('report-period-session', 'OrganizationReportController@periodSession')->name('organization.report.periodSession');
Route::resource('online-application', 'OnlineApplicationController');
Route::get('patient/{regNumber}/search', 'OnlineApplicationController@regFilter')->name('regFilter');
Route::get('change-password/{user}', 'UserPasswordController@form')->name('password.change.form');
Route::put('change-password/{user}', 'UserPasswordController@change')->name('password.change');

Route::get('mysettings', 'UserSettingsController@index')->name('user.settings.index');
Route::post('mysettings', 'UserSettingsController@sync')->name('user.settings.sync');

Route::get('print/{tokenNumber}/token', 'PrintController@token')->name('print.token');
Route::get('print/{organization}/personal-sifaris', 'PrintController@personalSifaris')->name('print.personal-sifaris');
Route::get('print/{organization}/ward-sifaris', 'PrintController@wardSifaris')->name('print.ward-sifaris');
Route::get('print/{organization}/pramanpatra-front', 'PrintController@pramanpatraFront')->name('print.pramanpatra-front');
Route::get('print/{organization}/pramanpatra-back', 'PrintController@pramanpatraBack')->name('print.pramanpatra-back');
Route::get('print/{organization}/gharelu-sifaris', 'PrintController@ghareluSifaris')->name('print.gharelu-sifaris');
Route::get('print/{organization}/kardata-sifaris', 'PrintController@kardataSifaris')->name('print.kardata-sifaris');
Route::get('print/{organization}/banijya-sifaris', 'PrintController@banijyaSifaris')->name('print.banijya-sifaris');
Route::get('print/{organization}/karobar-paribartan', 'PrintController@karobarParibartan')->name('print.karobar-paribartan');
// banda sifaris letters
Route::get('print/{organization}/banda-sifaris-gharelu', 'PrintController@bandaSifarisGharelu')->name('print.banda-sifaris-gharelu');
Route::get('print/{organization}/banda-sifaris-kardata', 'PrintController@bandaSifarisKardata')->name('print.banda-sifaris-kardata');
Route::get('print/{organization}/banda-sifaris-banijya', 'PrintController@bandaSifarisBanijya')->name('print.banda-sifaris-banijya');

Route::get('token/{tokenNumber}', 'TokenController@index')->name('token.index');
Route::get('token', 'TokenController@search')->name('token.search');

Route::get('settings', 'SettingsController@index')->name('settings.index');
Route::get('settings/system', 'SettingsController@system')->name('settings.system');
Route::get('settings/application', 'SettingsController@application')->name('settings.application');
Route::get('settings/document', 'SettingsController@document')->name('settings.document');
Route::get('settings/document/{id}', 'SettingsController@documentEdit')->name('settings.document.edit');
Route::get('settings/reasons', 'SettingsController@reason')->name('settings.reason');
Route::get('settings/position', 'SettingsController@position')->name('settings.position');
Route::get('settings/committee-position', 'SettingsController@committeePosition')->name('settings.committeePosition');
Route::post('settings', 'SettingsController@sync')->name('settings.sync');

Route::post('position', [PositionController::class, 'store'])->name('position.store');
Route::get('position/{position}', [PositionController::class, 'edit'])->name('position.edit');
Route::put('position/update/{position}', [PositionController::class, 'update'])->name('position.update');
Route::delete('position/{position}', [PositionController::class, 'delete'])->name('position.delete');

Route::post('committee-position', [CommitteePositionController::class, 'store'])->name('committeePosition.store');
Route::get('committee-position/{committeePosition}', [CommitteePositionController::class, 'edit'])->name('committeePosition.edit');
Route::put('committee-position/update/{committeePosition}', [CommitteePositionController::class, 'update'])->name('committeePosition.update');
Route::delete('committee-position/{committeePosition}', [CommitteePositionController::class, 'delete'])->name('committeePosition.delete');

Route::get('configuration-checklist', 'ConfigurationChecklistController@index')->name('configuration-checklist.index');

Route::group(
    [
        'middleware' => ['auth', 'role:super-admin']
    ],
    function () {
        Route::get('admin/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.logs');
    }
);

Route::prefix('diseases')->group(function () {
    Route::get('/', [DiseasesController::class, 'index'])->name('diseases.index');
    Route::post('/', [DiseasesController::class, 'store'])->name('diseases.store');
    Route::get('/{id}/edit', [DiseasesController::class, 'edit'])->name('diseases.edit');
    Route::put('/{id}', [DiseasesController::class, 'update'])->name('diseases.update');
    Route::delete('/{id}', [DiseasesController::class, 'destroy'])->name('diseases.destroy');
});

Route::prefix('application-types')->group(function () {
    Route::get('/', [ApplicationTypesController::class, 'index'])->name('application-types.index');
    Route::get('/create', [ApplicationTypesController::class, 'create'])->name('application-types.create');
    Route::post('/store', [ApplicationTypesController::class, 'store'])->name('application-types.store');
    Route::get('/{id}/edit', [ApplicationTypesController::class, 'edit'])->name('application-types.edit');
    Route::put('/{id}', [ApplicationTypesController::class, 'update'])->name('application-types.update');
    Route::delete('/{id}', [ApplicationTypesController::class, 'destroy'])->name('application-types.destroy');
});

Route::prefix('resources')->group(function () {
    Route::get('/', [ResourcesController::class, 'index'])->name('resources.index');
    Route::get('/create', [ResourcesController::class, 'create'])->name('resources.create');
    Route::post('/store', [ResourcesController::class, 'store'])->name('resources.store');
    Route::get('/{resource}/edit', [ResourcesController::class, 'edit'])->name('resources.edit');
    Route::put('/{resource}', [ResourcesController::class, 'update'])->name('resources.update');
    Route::delete('/{resource}', [ResourcesController::class, 'destroy'])->name('resources.destroy');
});



Route::prefix('units')->group(function () {
    Route::get('/', [UnitsController::class, 'index'])->name('units.index');
    Route::get('/create', [UnitsController::class, 'create'])->name('units.create');
    Route::post('/store', [UnitsController::class, 'store'])->name('units.store');
    Route::get('/{id}/edit', [UnitsController::class, 'edit'])->name('units.edit');
    Route::put('/{id}', [UnitsController::class, 'update'])->name('units.update');
    Route::delete('/{id}', [UnitsController::class, 'destroy'])->name('units.destroy');
});

Route::prefix('distributions')->group(function () {
    Route::get('/', [DistributionController::class, 'index'])->name('distributions.index');
    Route::get('/create', [DistributionController::class, 'create'])->name('distributions.create');
    Route::post('/', [DistributionController::class, 'store'])->name('distributions.store');
    Route::get('/{distribution}/edit', [DistributionController::class, 'edit'])->name('distributions.edit');
    Route::put('/{distribution}', [DistributionController::class, 'update'])->name('distributions.update');
    Route::delete('/{distribution}', [DistributionController::class, 'destroy'])->name('distributions.destroy');
    Route::resource('distributions', DistributionController::class)->except('show');
});


Route::prefix('disease')->group(function () {
    Route::get('/', [DiseaseController::class, 'index'])->name('disease.index');
    Route::post('/', [DiseaseController::class, 'store'])->name('disease.store');
    Route::get('/{disease}/edit', [DiseaseController::class, 'edit'])->name('disease.edit');
    Route::put('/{disease}/update', [DiseaseController::class, 'update'])->name('disease.update');
    Route::delete('/{disease}/destroy', [DiseaseController::class, 'destroy'])->name('disease.destroy');
    Route::get('/{diseaseId}/disease', [DiseaseController::class, 'getAll'])->name('disease.getAll');
});
Route::get('get/disease/{typeId}', [DiseaseController::class, 'getDisease'])->name('disease.getDisease');
Route::get('old-organizations', 'OldOrganizationController@create')->name('old-organizations.create');


Route::get('get-district/{provinceId}', [ProvinceController::class, 'getDistrict'])->name('get.district');
Route::get('get-municipality/{districtId}', [DistrictController::class, 'getMunicipality'])->name('get.municipality');
Route::get('get-ward/{municipalityId}', [DistrictController::class, 'getward'])->name('get.ward');

Route::prefix('patient')->group(function () {
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');
    Route::post('/application/apply', [PatientController::class, 'applicationApply'])->name('patient.applicationApply');
    Route::post('/recommendation', [PatientController::class, 'recommendation'])->name('patient.recommendation');
    Route::put('/{patient}/registration', [PatientController::class, 'update'])->name('patient.update');
    Route::put('/{patient}/registrations', [PatientController::class, 'registration'])->name('patient.registration');
    Route::get('/recommended', [PatientController::class, 'recommended'])->name('patient.recommended');
    Route::get('/registered', [PatientController::class, 'registered'])->name('patient.registered');
    Route::put('/{patient}/renew', [PatientController::class, 'renew'])->name('patient.renew');
    Route::put('/{patient}/closed', [PatientController::class, 'closed'])->name('patient.closed');
    Route::get('closed', [PatientController::class, 'closedPatient'])->name('patient.get.closed');
    Route::get('/', [PatientController::class, 'index'])->name('patient.index');
    Route::delete('/delete/{patient}', [PatientController::class, 'delete'])->name('patient.destroy');
    Route::get('/check-data', [PatientController::class, 'checkData'])->name('checkData');
    Route::post('/document-upload/{patient}', [PatientController::class, 'documentUpload'])->name('documentUpload');

    Route::put('/{patient}/doctor', [PatientDoctorController::class, 'store'])->name('patient.doctor');
    Route::put('/{patient}/kshati/{index}', [PatientController::class, 'updateKshatiPhoto'])
        ->name('kshati.update.single');

    Route::delete('/{patient}/kshati/{index}', [PatientController::class, 'deleteKshatiPhoto'])
        ->name('kshati.delete.single');
    Route::post('/{patient}/kshati/add', [PatientController::class, 'addKshatiPhoto'])
        ->name('kshati.add');

    Route::put('/{patient}/payment', [PatientController::class, 'updatePayment'])->name('patients.updatePayment');

    Route::get('/distribution/form', [PatientController::class, 'distributionForm'])->name('distributions.distribution.form');
});

Route::get('application-submitted/{patient}', [FrontendController::class, 'applicationSubmited'])->name('applicationSubmited');
Route::get('schedule-one/{patient}', [FrontendController::class, 'scheduleOne'])->name('schedule.one');
Route::get('schedule-two/{patient}', [FrontendController::class, 'scheduleTwo'])->name('schedule.two');
Route::get('suchi-print-application/{patient}', [FrontendController::class, 'suchiPrint'])->name('suchi-print-application');
Route::get('decision-document', [FrontendController::class, 'decision'])->name('decision.document');
Route::post('decision-document123', [FrontendController::class, 'decisionDocuments'])->name('decisionDocuments');

Route::get('district-list/{id}', [UserSettingsController::class, 'getDistrict'])->name('getDistrict');
Route::get('municipality-list/{id}', [UserSettingsController::class, 'getMunicipality'])->name('getMunicipality');
Route::get('set-organization', [UserSettingsController::class, 'setOrganization'])->name('setOrganization');
Route::get('set-fiscalYear', [UserSettingsController::class, 'setFiscalYear'])->name('setFiscalYear');


Route::get('new-applications', [ApplicationController::class, 'newApplication'])->name('newApplication');
Route::get('registered-applications', [ApplicationController::class, 'regLocation'])->name('regLocation');
Route::get('hospital-sifaris/{patient}', [ApplicationController::class, 'hospitalSifaris'])->name('hospitalSifaris');
Route::post('hospital-sifaris/{patient}', [ApplicationController::class, 'assignHospital'])->name('assignHospital');
Route::get('closed-applications', [ApplicationController::class, 'closedPatient'])->name('closedPatient');
Route::get('renewed-applications', [ApplicationController::class, 'renewedPatient'])->name('renewedPatient');
Route::get('expired-applications', [ApplicationController::class, 'dateExpiredPatient'])->name('dateExpiredPatient');
Route::get('sifaris/{patient}', [ApplicationController::class, 'SocialRecommandation'])->name('SocialRecommandation');

Route::put('application-type-price-update', [ApplicationTypeController::class, 'update'])->name('application-type-update');
Route::get('notification', function () {
    event(new NotificationEvent("Hello"));
});

Route::post('letter-pad', [LetterPadController::class, 'store'])->name('letterpadding.store');
Route::put('letter-pad/{id}', [LetterPadController::class, 'update'])->name('letterpadding.update');

Route::post('downloadable-document', [DownloadController::class, 'store'])->name('download.store');
Route::put('downloadable-document/{id}', [DownloadController::class, 'downloadUpdate'])->name('download.update');
Route::delete('downloadable-document/{download}', [DownloadController::class, 'delete'])->name('download.delete');

Route::post('reason', [ReasonController::class, 'store'])->name('reason.store');
Route::put('reason/{reason}/update', [ReasonController::class, 'update'])->name('reason.update');
Route::delete('reason/{reason}', [ReasonController::class, 'delete'])->name('reason.delete');
Route::get('reason/{reason}/edit', [ReasonController::class, 'edit'])->name('reason.edit');


Route::get('hospital', [HospitalController::class, 'index'])->name('hospital.index');
Route::post('hospital', [HospitalController::class, 'store'])->name('hospital.store');
Route::get('hospital/{hospital}', [HospitalController::class, 'edit'])->name('hospital.edit');
Route::put('hospital/{hospital}', [HospitalController::class, 'update'])->name('hospital.update');
Route::delete('hospital/{hospital}', [HospitalController::class, 'delete'])->name('hospital.delete');
Route::get('hospital-disease/{id}', [HospitalController::class, 'getDisease'])->name('hospital.getDisease');

Route::get('committee', [CommitteeController::class, 'index'])->name('committee.index');
Route::post('committee', [CommitteeController::class, 'store'])->name('committee.store');
Route::get('committee/{committee}', [CommitteeController::class, 'edit'])->name('committee.edit');
Route::put('committee/{committee}', [CommitteeController::class, 'update'])->name('committee.update');
Route::delete('committee/{committee}', [CommitteeController::class, 'delete'])->name('committee.delete');


Route::get('member', [MemberController::class, 'index'])->name('member.index');
Route::post('member', [MemberController::class, 'store'])->name('member.store');
Route::get('member/{member}', [MemberController::class, 'edit'])->name('member.edit');
Route::put('member/{member}', [MemberController::class, 'update'])->name('member.update');
Route::delete('member/{member}', [MemberController::class, 'delete'])->name('member.delete');
Route::post('member/order', [MemberController::class, 'order'])->name('member.order');

Route::get('settings/sms', [SmsController::class, 'index'])->name('sms.index');
Route::post('settings/sms', [SmsController::class, 'sync'])->name('sms.store');

Route::post('token/store', [OnesignaltokenController::class, 'store'])->name('token.store');
Route::get('settings/one-signal', [OnesignaltokenController::class, 'onesignal'])->name('token.onesignal');
Route::post('settings/one-signal', [OnesignaltokenController::class, 'onesignalSync'])->name('token.onesignal.sync');


Route::put('re-upload-image/{id}', [PatientController::class, 'reuploadImage'])->name('reuploadImage');


Route::get('role', [RoleController::class, 'index'])->name('role.index');
Route::post('role/create', [RoleController::class, 'store'])->name('role.store');
Route::get('role/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::put('role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::delete('role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
Route::get('permission/{id}', [RoleController::class, 'permission'])->name('role.permission');
Route::put('permission/sync/{id}', [RoleController::class, 'permissionSync'])->name('role.permissionSync');

Route::get('download-word1', function () {
    // $file_name = strtotime(date('Y-m-d H:i:s')) . '_advertisement_template.doc';
    // $headers = array(
    //     "Content-type"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    //     "Content-Disposition"=>"attachment;Filename=$file_name"
    // );
    // $patient = App\Patient::find('1799');
    // $plainContent = view('frontend.hospitalSifaris', compact('patient'));
    // $htmlContent = view('frontend.hospitalSifaris', compact('patient'))->render();

    // $rawContent = htmlspecialchars($htmlContent);
    // return Response::make($rawContent, 200, $headers);
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    // Adding Text element to the Section having font styled by default...
    $section->addText(
        '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
    );
    $phpWord = new PhpWord();
    $section->addText(
        '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
        array('name' => 'Tahoma', 'size' => 10)
    );

    // Adding Text element with font customized using named font style...
    $fontStyleName = 'oneUserDefinedStyle';
    $phpWord->addFontStyle(
        $fontStyleName,
        array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
    );
    $section->addText(
        '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
        $fontStyleName
    );

    // Adding Text element with font customized using explicitly created font style object...
    $fontStyle = new \PhpOffice\PhpWord\Style\Font();
    $fontStyle->setBold(true);
    $fontStyle->setName('Tahoma');
    $fontStyle->setSize(13);
    $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
    $myTextElement->setFontStyle($fontStyle);

    // Saving the document as OOXML file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('helloWorld.docx');

    // Saving the document as ODF file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
    $objWriter->save('helloWorld.odt');

    // Saving the document as HTML file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
    $objWriter->save('helloWorld.html');

    // Prepare headers to force download the file
    return response()->download($objWriter, 'patient_sifaris.doc')->deleteFileAfterSend(true);
});


Route::get('/search/token', [SearchController::class, 'search'])->name('token.search');



Route::get('download-word', function () {
    // $phpWord = new PhpWord();
    // $section = $phpWord->addSection();

    // $patient = App\Patient::find(1799);

    // $section->addTitle('आज मिति', 1);

    // $tableStyle = [
    //     'borderSize' => 6,
    //     'borderColor' => '999999',
    //     'cellMargin' => 80,
    // ];
    // $phpWord->addTableStyle('PatientTable', $tableStyle);
    // $table = $section->addTable('PatientTable');

    // $table->addRow();
    // $table->addCell(2000)->addText('Field', ['bold' => true]);
    // $table->addCell(5000)->addText('Value', ['bold' => true]);

    // $table->addRow();
    // $table->addCell(2000)->addText('Name');
    // $table->addCell(5000)->addText($patient->name);

    // $table->addRow();
    // $table->addCell(2000)->addText('Details');
    // $table->addCell(5000)->addText($patient->details);

    // $tempFilePath = tempnam(sys_get_temp_dir(), 'PHPWord') . '.docx';
    // $writer = IOFactory::createWriter($phpWord, 'Word2007');
    // $writer->save($tempFilePath);

    // return response()->download($tempFilePath, 'patient_sifaris.docx')->deleteFileAfterSend(true);


});



Route::get('download-word/{id}', [PatientController::class, 'wordExport'])->name('word');

Route::get('relation-with-patient', [RelationController::class, 'index'])->name('relation.index');
Route::post('relation-with-patient', [RelationController::class, 'store'])->name('relation.store');
Route::get('relation-with-patient/{relation}/edit', [RelationController::class, 'edit'])->name('relation.edit');
Route::put('relation-with-patient/{relation}/update', [RelationController::class, 'update'])->name('relation.update');
Route::delete('relation-with-patient/{relation}/delete', [RelationController::class, 'delete'])->name('relation.delete');


Route::get('bipanna-report', 'OrganizationReportController@bipannaFinalReport')->name('organization.bipanna-final-report');
Route::get('hospital-wise-report', 'OrganizationReportController@hospitalWiseReport')->name('organization.hospitalWiseReport');
Route::get('disease-wise-report', 'OrganizationReportController@diseaseWiseReport')->name('organization.diseaseWiseReport');
Route::get('social-development-ministry/report', 'OrganizationReportController@socialDevelopmentMinistryFianlReport')->name('social-development.report');
Route::get('social-development-ministry', 'OrganizationReportController@socialDevelopmentMinistryReport')->name('socialDevelopmentMinistryReport');
Route::get('municipality-health-relief-fund', 'OrganizationReportController@municipalityHealthRelifFund')->name('municipalityReport');
Route::get('registered-patient-report', 'OrganizationReportController@registeredPatientReport')->name('organization.registeredPatientReport');
Route::get('relief-report', 'OrganizationReportController@reliefReport')->name('organization.relief-report');
Route::get('resource-distribution-report', 'OrganizationReportController@resourceDistributionReport')->name('organization.resource-distribution-report');


// Route::get('user-role', 'UserController@userRole');

Route::get('/faqs', [FaqsController::class, 'faqs'])->name('frontent.faqs');

Route::get('payment-procedure', [PaymentController::class, 'index'])->name('payment.procedure');
Route::get('patient-list', [PaymentController::class, 'patientList'])->name('patient.list');
Route::get('pay', [PaymentController::class, 'pay'])->name('payment');
Route::get('payment-export', [PaymentController::class, 'export'])->name('payment.export');

Route::get('profile', [DoctorProfileController::class, 'index'])->name('doctor.profile');
Route::put('profile-update', [DoctorProfileController::class, 'update'])->name('doctor.profile.update');
Route::get('get-doctor/{id}', [DoctorProfileController::class, 'getDoctor'])->name('getDoctor');

Route::post('print-desision', [DecisionController::class, 'index'])->name('print-decision');

Route::get('{patientId}/search-patient', [SearchController::class, 'searchPatient'])->name('searchPatient');
Route::post('search-patient', [SearchController::class, 'reApply'])->name('reApply');

Route::post('/decision/store', [SifarishController::class, 'store'])->name('sifarish.store');
Route::get('/decision/index', [SifarishController::class, 'index'])->name('decision.index');
Route::post('/decisions/{decision}/upload-file', [DecisionController::class, 'uploadFile'])->name('decisions.upload-file');

Route::get('/distributions/form/{decision}', [SifarishController::class, 'showDistributionForm'])->name('distributions.distribution.form');
Route::post('/distributions/save', [PaymentsController::class, 'store'])->name('distributions.save');
Route::get('/payments/index', [PaymentsController::class, 'index'])->name('payments.index');


