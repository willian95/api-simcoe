<?php

use Carbon\Carbon;

function picture($request,$id)
{

    $fileRoute="";

    if($request->hasFile('picture'))
    {

        $fileType = "";

        $originName = $request->file('file')->getClientOriginalName();
    
        $extension = $request->file('file')->getClientOriginalExtension();
    
        $fileName = $id.'.'.$extension;
    
        $request->file('file')->move(public_path('picture'), $fileName);
    
        $fileRoute = url('/').'/picture/'.$fileName;

    }

    return $fileRoute;
}