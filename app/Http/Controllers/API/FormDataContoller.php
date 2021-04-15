<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FormDataRequest;
use App\Models\FormData;
use Illuminate\Database\QueryException;

class FormDataContoller extends Controller
{
    public function store(FormDataRequest $request){

        try {

            $formData = new FormData();
            $formData->name   = $request->get('name');
            $formData->surname = $request->get('surname');
            if( NULL != $request->get('file') ){

                $base64 = $request->get('file');

                if( isset( explode('base64',$base64)[1] )){

                    $img_decoded = explode('base64',$base64)[1];

                    $image_info = getimagesize($base64);
                    $mimeType = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

                    if( $mimeType=="png" || $mimeType == "jpg" || $mimeType = 'jpeg' ){
                        $newfileName = date("Ymdgis") . "." . $mimeType;
                        $img_decoded = base64_decode ($img_decoded);
                        if (!$img = fopen ( public_path().'/images/'.$newfileName, 'w')) {
                        } else{
                            if (fwrite($img, $img_decoded) === FALSE) {
                            }
                            fclose ($img);
                            chmod( public_path().'/images/'.$newfileName, 0775 );
                            $formData->link = $newfileName;
                        }
                    } else{
                        return response()->json([ 'success' => false, 'err' => 'zły typ plików' ]);
                    }
                }
            }
            $formData->save();
            return response()->json([ 'success' => true ]);
        } catch (QueryException $e) {
            return response()->json([ 'success' => false, 'err' => $e->getMessage() ]);
        }
    }
}
