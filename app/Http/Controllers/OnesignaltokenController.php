<?php

namespace App\Http\Controllers;

use App\Onesignaltoken;
use Illuminate\Http\Request;

class OnesignaltokenController extends Controller
{
    public function store(Request $request)
    {
        //    return $request;
        $onesignal = Onesignaltoken::where('token', $request->token)->where('user_id', $request->user_id)->first();
        if (!$onesignal) {
            Onesignaltoken::create([
                'user_id' => $request->user_id,
                'token' => $request->token,
            ]);
        }



        return response()->json([
            'success' => true,
        ]);
    }

    public function onesignal()
    {
        return view('settings.onesignal');
    }

    public function onesignalSync(Request $request)
    {
        $request->validate([
            'onesignal_app_id'=>'required',
            'onesignal_api_key'=>'required',
        ]);
        settings()->set([
            'onesignal_app_id' => $request->onesignal_app_id,
            'onesignal_api_key' => $request->onesignal_api_key,
        ]);

        $this->setEnvValue('ONESIGNAL_APP_ID', $request->onesignal_app_id);
        $this->setEnvValue('ONESIGNAL_REST_API_KEY', $request->onesignal_api_key);
        return redirect()->back()->with('success', 'Onesignal setting changed');
    }

    public function setEnvValue($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $env = file_get_contents($path);

            // Check if the key already exists
            if (strpos($env, "{$key}=") !== false) {
                // Replace the existing value
                $env = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $env);
            } else {
                // Append the new value at the end
                $env .= "{$key}={$value}\n";
            }

            // Write the new file content back to the .env file
            file_put_contents($path, $env);
        }
    }
}
