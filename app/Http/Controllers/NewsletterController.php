<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class NewsletterController extends Controller
{
    public function send()
    {
        Artisan::call('send:newsletter');

        return response()->json([
            'data' => 'OK',
        ]);
    }
}
