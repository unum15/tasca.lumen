<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Contact;

class SMSController extends Controller
{
    
    public function response(Request $request)
    {
	    $input = $request->input();
	    Log::Error($input);
    }
}

