<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactAdminMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function sendmail(ContactRequest $request)
    {
        // バリデーション済みのデータを取得
        $validated_request= $request->validated();

        // Log::debug($validated['name']. 'さんよりお問い合わせがありました。');
        Mail::to(users: 'user@example.com')->send(new ContactAdminMail($validated_request));

        return to_route('contact.complete');
    }

    public function complete()
    {
        return view('contact.complete');
    }
}
