<?php

namespace App;

use File;
use Storage;

class FileUpload
{
    public static function photo($request, $fileName, $default = "")
    {
    	$name = "";
    	$photo = $request->photo;

    	if($request)
    	{
    		$extension = $photo->getClientOriginalExtension();
    		$name = rand(11111, 99999) . "." . date('Y-m-d') . "." . time() . "." . $extension;
    		//Storage::disk('photo')->put($name, $photo);
    		Storage::disk('photo')->put($name, File::get($photo));

    	} else {
    		$name = $default;
           
    	}

    	return $name;
    }
}
