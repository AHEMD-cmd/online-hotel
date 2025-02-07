<?php

namespace App\Http\Controllers\Front;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{
    public function sendEmail(Request $request)
    {
        $email = $request->validate([
            'email' => 'required|email'
        ]);

        $subscriber = Subscriber::create([
            'email' => $request->email
        ]);

        return response()->json(['code' => 1, 'success_message' => 'you are subscribed successfully']);
    }
}
