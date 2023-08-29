<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;

class TransfersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'from_email' => 'required|email',
            'to_email' => 'required|email',
            'title' => 'required|min:3',
            'message' => 'nullable|min:5',
            'file' => 'required|file|max:2097152',
        ]);

        $request->file('file')->storeAs('transfers', $request->file('file')->getClientOriginalName());

        Transfer::create([
            'from_email' => $request->input('from_email'),
            'to_email' => $request->input('to_email'),
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'file' => $request->file('file')->getClientOriginalName(),
        ]);

        return back();
    }
}
