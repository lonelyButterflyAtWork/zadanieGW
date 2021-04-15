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

                $file = $request->get('file');
                $filename =  microtime('.') * 10000;
                $destination = 'images';
                $formData->link = $filename;
                $file->move($destination, $filename);
            }
            $formData->save();
            return response()->json([ 'success' => true ]);

        } catch (QueryException $e) {
            return response()->json([ 'success' => false, 'err' => $e->getMessage() ]);
        }
    }
}
