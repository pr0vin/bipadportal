<?php

use App\Month;
use Carbon\Carbon;
use App\FiscalYear;
use Spatie\Permission\Models\Role;
use App\Services\FiscalYearService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

if (!function_exists('setActive')) {
    /**
     * Check if the route is active or not
     *
     * @param  string  $key
     * @return string
     */
    function setActive($path, $active = 'active')
    {
        return Request::routeIs($path) ? $active : '';
    }

    function setShow($path, $active = 'show')
    {
        return Request::routeIs($path) ? $active : '';
    }
}

if (!function_exists('invalid_class')) {
    /**
     * Check for the existence of an error message and return a class name
     *
     * @param  string  $key
     * @return string
     */
    function invalid_class($key)
    {
        $errors = session()->get('errors') ?: new \Illuminate\Support\ViewErrorBag;
        return $errors->has($key) ? 'is-invalid' : '';
    }
}


if (!function_exists('invalid_feedback')) {
    /**
     * Check if the route is active or not
     *
     * @param  string  $key
     * @return string
     */
    function invalid_feedback($key)
    {
        $key = str_replace(['\'', '"'], '', $key);
        $errors = session()->get('errors') ?: new \Illuminate\Support\ViewErrorBag;
        if ($message = $errors->first($key)) {
            return '<?= <div class="invalid-feedback">' . $message . '</div>; ?';
        }
    }
}


function runningFiscalYear($key = null)
{
    $runningFiscalYear = app(FiscalYearService::class)->getRunning();

    return $key != null
        ? $runningFiscalYear->$key
        : $runningFiscalYear;
}


if (!function_exists('slashDateFormat')) {
    /**
     * Format the date to slash(/) format
     *
     * @param  mixed $date
     * @return void
     */
    function slashDateFormat($date)
    {
        return str_replace('-', '/', $date);
    }
}

if (!function_exists('copyCountText')) {
    function copyCountText($count)
    {
        switch ($count) {
            case 1:
                return 'प्रथम';
                break;
            case 2:
                return 'दोस्रो';
                break;
            case 3:
                return 'तेस्रो';
                break;
            case 4:
                return 'चौथो';
                break;
            case 5:
                return 'पाँचौं';
                break;
            default:
                return $count;
                break;
        }
    }
}

if (!function_exists('bs_to_ad')) {
    function bs_to_ad($npDate)
    {
        return \App\Helpers\BSDateHelper::BsToAd('-', $npDate);
    }
}

if (!function_exists('ad_to_bs')) {
    function ad_to_bs($enDate)
    {
        return \App\Helpers\BSDateHelper::AdToBsEn('-', $enDate);
    }
}

function municipalityId()
{
    foreach (Auth::user()->roles  as $role) {
        if ($role->name == 'super-admin') {
            return Session::get('municipality_id');
        } else {
            return Auth::user()->municipality_id;
        }
    }
}

function getMonth($month)
{
    if ($month == "1") {
        return "बैशाख";
    } elseif ($month == "2") {
        return "जेष्ठ";
    } elseif ($month == "3") {
        return "असार";
    } elseif ($month == "4") {
        return "साउन";
    } elseif ($month == "5") {
        return "भद्र";
    } elseif ($month == "6") {
        return "असोज";
    } elseif ($month == "7") {
        return "कार्तिक";
    } elseif ($month == "8") {
        return "मंसिर";
    } elseif ($month == "9") {
        return "पुस";
    } elseif ($month == "10") {
        return "माघ";
    } elseif ($month == "11") {
        return "फाल्गुन";
    } else {
        return "चैत्र";
    }
}

function nextRenewDate($myDate)
{
    $renewMonth = Carbon::parse($myDate)->format('m');
    $renewYear = Carbon::parse($myDate)->format('Y');
    $renewDate = Carbon::parse($myDate);
    $months = Month::orderBy('id', 'asc')->get();
    if ($renewMonth <= 10) {
        foreach ($months as $month) {
            $next = $renewYear . "-" . $month->month . "-1";
            $nextDate = Carbon::parse($next);
            if ($renewDate < $nextDate) {
                return $nextDate->format('Y-m-d');
            }
        }
    } else {
        return ($renewYear + 1) . "-1-1";
    }
}

function renewDate($myDate)
{
    // return now();
    $myDate1 = ad_to_bs(now()->format('Y-m-d'));
    $renewMonth = Carbon::parse($myDate1)->format('m');
    $renewYear = Carbon::parse($myDate1)->format('Y');
    $renewDate = Carbon::parse($myDate1);
    $months = Month::orderBy('id', 'asc')->get();
    $nextRenewDate = null;
    if ($renewMonth <= 10) {
        foreach ($months as $month) {
            $next = $renewYear . "-" . $month->month . "-1";
            $nextDate = Carbon::parse($next);
            if ($renewDate < $nextDate) {
                return $nextDate->format('Y-m-d');
            }
        }
    } else {
        return ($renewYear + 1) . "-1-1";
    }
}

function totalMonth($month1, $month2)
{
    if ($month1 == 10) {
        return 3;
    } elseif ($month1 == 11) {
        return 2;
    } elseif ($month1 == 12) {
        return 1;
    } else {

        return $diff = $month2 - $month1;
    }
}

function isExpired($date)
{
    $now = ad_to_bs(now()->format('Y-m-d'));
    $nextDate = Carbon::parse($date);
    if ($now > $nextDate) {
        return true;
    }
    return false;
}
function nepaliToEnglishLetters($nepaliDate)
{
    $nepaliLetters = array('०' => '0', '१' => '1', '२' => '2', '३' => '3', '४' => '4', '५' => '5', '६' => '6', '७' => '7', '८' => '8', '९' => '9');
    $englishDate = strtr($nepaliDate, $nepaliLetters);
    return $englishDate;
}
function englishToNepaliLetters($englishDate)
{
    $englishToNepaliLetters = array(
        '0' => '०',
        '1' => '१',
        '2' => '२',
        '3' => '३',
        '4' => '४',
        '5' => '५',
        '6' => '६',
        '7' => '७',
        '8' => '८',
        '9' => '९'
    );
    $nepaliDate = strtr($englishDate, $englishToNepaliLetters);
    return $nepaliDate;
}

function currentFiscalYear()
{
    return FiscalYear::where('is_running', true)->first();
}


function dateFormat($date)
{
    // if($date){
    return Carbon::parse($date)->format('Y/m/d');
    // }
}

function formatDate($date)
{
    // if($date){
    return Carbon::parse($date)->format('Y-m-d');
    // }
}
function timePeriod($month)
{
    if ($month >= 1 && $month <= 3) {
        $period = "1";
    } elseif ($month >= 4 && $month <= 6) {
        $period = "4";
    } elseif ($month >= 7 && $month <= 9) {
        $period = "7";
    } elseif ($month >= 10 && $month <= 12) {
        $period = "10";
    } else {
        $period = "Invalid month";
    }
    if (Session::get('renewalPeriod')) {
        $period = Session::get('renewalPeriod');
    }
    $date = [];

    if ($period == "1") {
        $periodYearFrom = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '01-01';
        $periodYearTo = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '03-30';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '1';
    }
    if ($period == "4") {
        $periodYearFrom = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '04-01';
        $periodYearTo = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '06-30';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '4';
    }
    if ($period == "7") {
        $periodYearFrom = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '7-01';
        $periodYearTo = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '09-30';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '7';
    }
    if ($period == "10") {
        $periodYearFrom = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '10-01';
        $periodYearTo = explode('/', ad_to_bs(today()->format('Y-m-d')))[0] . '-' . '12-30';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '10';
    }

    return $date;
}


function checkPermission($permissions, $typeId)
{


    $accessibleApplications = [];
    $id = "";


    foreach ($permissions as $type => $permission) {
        if (Gate::allows($permission)) {
            if ($type == $typeId) {
                $accessibleApplications[] = $type;
                $id = $type;
            }
        }
    }
    // dd($accessibleApplications);

    if (empty($accessibleApplications)) {
        abort(403, 'Unauthorized action.');
    }
    return $id;
}

function currentquarter()
{
    $currentDate = ad_to_bs(today()->format('Y-m-d'));
    $dateParts = explode('/', $currentDate);
    $month = $dateParts[1];
    $month = (int)$month;

    if ($month >= 4 && $month <= 6) {
        return 1;
    } elseif ($month >= 7 && $month <= 9) {
        return 2;
    } elseif ($month >= 10 && $month <= 12) {
        return 3;
    } else {
        return 4;
    }
}

function currentQuarterDate()
{
    $todayDate = ad_to_bs(today()->format('Y-m-d'));

    $year = explode('/', $todayDate)[0];
    $quarter = currentQuarter();

    switch ($quarter) {
        case 1:
            return $year . '-04-01';
        case 2:
            return $year . '-07-01';
        case 3:
            return $year . '-10-01';
        case 4:
            return $year . '-01-01';
    }
}

function currentQuarterEndDate()
{
    $todayDate = ad_to_bs(today()->format('Y-m-d'));

    $year = explode('/', $todayDate)[0];
    $quarter = currentQuarter();

    switch ($quarter) {
        case 1:
            return $year . '-07-01';
        case 2:
            return $year . '-10-01';
        case 3:
            return $year . '-01-01';
        case 4:
            return $year . '-04-01';
    }
}

function renewquarter($bsDate)
{
    if ($bsDate) {
        $currentDate = $bsDate;
        $dateParts = explode('-', $currentDate);
        $month = $dateParts[1];
        $month = (int)$month;

        if ($month >= 4 && $month <= 6) {
            return 1;
        } elseif ($month >= 7 && $month <= 9) {
            return 2;
        } elseif ($month >= 10 && $month <= 12) {
            return 3;
        } else {
            return 4;
        }
    }
}


function timePeriodFilter($period)
{

    $date = [];
    $year = explode('-', currentFiscalYear()->start)[0];
    if ($period == "1") {
        $periodYearFrom = $year+1 . '-' . '01-02';
        $periodYearTo = $year+1 . '-' . '03-32';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '1';
    }
    if ($period == "4") {
        $periodYearFrom = $year . '-' . '04-01';
        $periodYearTo = $year . '-' . '06-32';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '4';
    }
    if ($period == "7") {
        $periodYearFrom = $year . '-' . '07-01';
        $periodYearTo = $year . '-' . '09-32';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '7';
    }
    if ($period == "10") {
        $periodYearFrom = $year . '-' . '10-01';
        $periodYearTo = $year . '-' . '12-32';
        $date['from'] = $periodYearFrom;
        $date['to'] = $periodYearTo;
        $date['period'] = '10';
    }

    return $date;
}


function computeDOBFromAge($age)
{
    // Get the current date
    $currentDate = new DateTime();

    // Subtract the age from the current year
    $dobYear = $currentDate->format('Y') - $age;

    // Assuming the DOB is on the last day of the year (Dec 31) for simplicity
    $dob = new DateTime("$dobYear-12-31");

    // If the current date hasn't reached the birthday this year, subtract a year
    if ($currentDate < $dob) {
        $dob->modify('-1 year');
    }

    $patientDob = ad_to_bs($dob->format('Y-m-d')); // Format the date as needed
    $patientDob = explode('/', $patientDob);
    $patientDob1 = $patientDob[0] . '/' . $patientDob[1];
    return $patientDob1;
}


function renewMonth($nextRenewMonth)
{
    $date = new DateTime($nextRenewMonth);
    // $month=($month+1)."month";
    $newDate = $date->modify('-1 month');
    return $newDate->format('m');
    // $newDate=explode('-',$newDate);
    // return $newDate[1];
}
