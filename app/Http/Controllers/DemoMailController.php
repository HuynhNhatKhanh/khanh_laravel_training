<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;

class DemoMailController extends Controller
{
    public function sendMail()
    {
        $data = [
            'title' => 'Title Mail',
            'body' => 'This is the body of test email.'
        ];

        Mail::to('huynh.khanh.rcvn2012@gmail.com')->send(new DemoMail($data));

        dd('Success! Email has been sent successfully.');
    }
}
