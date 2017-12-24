<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    function image(Request $request)
    {
        if ($request->hasFile('image')) {

            return response()->json($request->input('image'));
        } else {
            return false;
        }

    }
}
