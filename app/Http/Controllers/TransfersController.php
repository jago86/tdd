<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Mail\TransferReceived;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TransfersController extends Controller
{

    public function download($hash)
    {
        $transfer = Transfer::where('hash', $hash)->first();
        $filePath = Storage::path($transfer->file);

        return response()
            ->streamDownload(function () use ($filePath) {
                readfile($filePath);
            }, basename($filePath), [
                'Content-type' => Storage::mimeType($transfer->file)
            ]);
    }

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

        $transfer = Transfer::create([
            'from_email' => $request->input('from_email'),
            'to_email' => $request->input('to_email'),
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'file' => $request->file('file')->getClientOriginalName(),
        ]);

        Mail::send(new TransferReceived($transfer));

        return back();
    }
}
