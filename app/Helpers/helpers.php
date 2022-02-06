<?php

use Carbon\Carbon;

function picture($request,$id)
{

    $fileRoute="";

    if($request->hasFile('picture'))
    {

        $fileType = "";

        $originName = $request->file('picture')->getClientOriginalName();
    
        $extension = $request->file('picture')->getClientOriginalExtension();
    
        $fileName = $id.'.'.$extension;
    
        $request->file('picture')->move(public_path('picture'), $fileName);
    
        $fileRoute = url('/').'/picture/'.$fileName;

    }

    return $fileRoute;
}