<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function send(Request $request, $title, $content)
    {
        //Logic will go here

        Mail::queue('email.sendemail', ['title' => $title, 'content' => $content], function ($message) {

            $message->from('wanmuz.ada@gmail.com', 'Admin');

            $message->to('aniqaimanimran@gmail.com');

        });

        return response()->json(['message' => 'Request completed']);

    }
}
