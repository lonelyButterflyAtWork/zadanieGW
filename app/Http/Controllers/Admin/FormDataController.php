<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormData;

class FormDataController extends Controller
{
    public function index(){

        $formData = FormData::all();
        return view('admin.index', compact('formData'));
    }
}
