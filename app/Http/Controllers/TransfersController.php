<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;

class TransfersController extends Controller
{
    public function store(Request $request)
    {
        Transfer::create([
            'from_email' => $request->input('from_email'),
            'to_email' => $request->input('to_email'),
            'title' => $request->input('title'),
            'message' => $request->input('message'),
        ]);

        return back();
    }
}
