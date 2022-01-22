<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use Response,File;

class FileController extends Controller
{
    function upload(UploadFileRequest $request){

        try {

            $fileType = "";

            $originName = $request->file('file')->getClientOriginalName();

            $extension = $request->file('file')->getClientOriginalExtension();

            $fileName = Carbon::now()->timestamp . '_' . uniqid().'.'.$extension;

            $request->file('file')->move(public_path('uploads'), $fileName);

            $fileRoute = url('/').'/uploads/'.$fileName;

            if(isset($request->secondaryFileType)){

                $fileType = $request->secondaryFileType;
                
            }

            return response()->json(["success" => true,"message" => "File uploaded successfully.","file_route" => $fileRoute, "original_name" => $originName,"extension" => $extension, "type" => $fileType]);

        } catch (JWTException $e) {

            Log::error($e);

            return response()->json(["success" => false,"message" => "The file could not be uploaded, please try again later."],500);


        }

    }
}
