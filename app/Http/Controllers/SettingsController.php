<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\Reason;
use App\Document;
use App\Download;
use App\Position;
use App\CommitteePosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            abort(403, 'You are not authorized to this resource');
        }
        $title = 'सेटिङ्हरू';
        $provinces = \App\Province::all(['id', 'name', 'name_en']);
        $districts = \App\District::all(['id', 'name', 'name_en', 'province_id']);
        $municipalities = \App\Municipality::all(['id', 'name', 'name_en', 'district_id']);
        $settings = collect(settings()->all());

        return view('settings.index', compact([
            'provinces',
            'districts',
            'municipalities',
            'settings',
            'title'
        ]));
    }

    public function system()
    {
        return view('settings.system');
    }
    public function application()
    {
        return view('settings.application');
    }

    public function document()
    {
        $document = new Download();
        return view('settings.document', compact('document'));
    }
    public function documentEdit($id)
    {
        $document = Download::find($id);
        return view('settings.document', compact('document'));
    }
    public function reason()
    {
        $reason = new Reason();
        return view('settings.reason', compact('reason'));
    }
    public function position()
    {
        $position = new Position();
        return view('settings.position', compact('position'));
    }

    public function committeePosition()
    {
        $committeePosition = new CommitteePosition();
        return view('settings.committeePosition', compact('committeePosition'));
    }



    public function sync(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            abort(403, 'You are not authorized to this resource');
        }

        $request->validate([
            // 'app_name' => 'required|email'
        ]);

        settings()->set($request->except('_token', 'user_manual'));
        if ($request->has('user_manual')) {
            if (settings()->get('user_manual')) {
                Storage::delete(settings()->get('user_manual'));
            }
            $data['user_manual'] = $request->file('user_manual')->store('user_manual');
            settings()->set('user_manual', $data['user_manual']);
        }
        return redirect()->back()->with('success', 'Settings have been saved');
    }
}
