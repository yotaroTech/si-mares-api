<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $validated['email'])->first();

        if ($existing) {
            if (!$existing->is_active) {
                $existing->update(['is_active' => true]);
                return response()->json(['message' => 'נרשמת מחדש בהצלחה']);
            }
            return response()->json(['message' => 'כבר רשום/ה לניוזלטר']);
        }

        NewsletterSubscriber::create($validated);

        return response()->json(['message' => 'נרשמת בהצלחה לניוזלטר'], 201);
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $subscriber = NewsletterSubscriber::where('token', $validated['token'])->firstOrFail();
        $subscriber->update(['is_active' => false]);

        return response()->json(['message' => 'הוסרת מרשימת התפוצה']);
    }
}
