<?php

namespace App\Http\Controllers\Front;

use App\Models\Page;
use App\Models\User;
use App\Mail\ContactEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $data = Page::first();
        return view('front.contact', compact('data'));
    }

    public function sendEmail(ContactRequest $request)
    {
        try {
            $admin = User::where('role', 'admin')->first();

            Mail::to($admin->email)->queue(new ContactEmail($request->validated()));

            return response()->json(['code' => 1, 'message' => 'Email sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['code' => 0, 'message' => 'Failed to send email!'], 500);
        }
    }
}
