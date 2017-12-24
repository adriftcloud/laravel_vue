<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UploadController extends Controller
{

    function getExtendedFileName($mime)
    {
        $mimes = [
            'image/jpeg' => 'jpg',
            'image/png'=>'png',
            'image/gif'=>'gif',

        ];
    }

    function image(Request $request)
    {
        //return $request->input();

        $data = explode(',', $request->image);


        return response()->json($data);


        //get the base-64 from data
        $base64_str = substr($request->image, strpos($request->image, ",") + 1);

        //decode base64 string
        $image = base64_decode($base64_str);
        $png_url = "product-" . time() . ".png";
        $path = public_path('img/designs/' . $png_url);

        Image::make($image->getRealPath())->save($path);
        // I've tried using
        // $result = file_put_contents($path, $image);
        // too but still not working

        $response = array(
            'status' => 'success',
        );
        return Response::json($response);

    }
}
