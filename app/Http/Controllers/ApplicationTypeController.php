<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationTypeController extends Controller
{
    public function update(Request $request)
    {
        $ids = [1, 2, 3, 4];


        foreach ($ids as $id) {

            ApplicationType::find($id)->update([

                'amount' => request()->input('amount_' . $id),

            ]);
        }


        return redirect()->back();
    }
}
