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

        $formData = new FormData();
        $formData->name   = $request->get('name');
        $formData->surname = $request->get('surname');
        try {

            $formData->save();
            return response()->json([ 'success' => true ]);

        } catch (QueryException $e) {
            return response()->json([ 'success' => false, 'err' => $e->getMessage() ]);
        }
    }
}
