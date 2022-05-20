<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function scrapping(Request $request)
    {
        return json_encode(['status' => 'OK', 'result' => $request->input('shopeelink')]);
    }
}
