<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function sendmail(ContactRequest $request)
    {
        $validated = $request->validated();

        Log::debug($validated['name']. 'さんよりお問い合わせがありました。');

        return to_route('contact.complete');
    }

    public function complete()
    {
        return view('contact.complete');
    }
}
