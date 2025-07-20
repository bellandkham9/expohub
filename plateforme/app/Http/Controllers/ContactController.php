<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        Mail::to('Expohubacademy@gmail.com')
            ->send(new ContactFormMail(
                $validated['name'],
                $validated['phone'],
                $validated['email'],
                $validated['message']
            ));

        return redirect()->back()->with('success', 'Message envoyé avec succès');
    }
}