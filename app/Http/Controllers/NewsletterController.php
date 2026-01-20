<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterConfirmMail;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
        ]);

        $subscription = NewsletterSubscription::where('email', $data['email'])->first();

        if ($subscription && $subscription->is_active && $subscription->confirmed_at) {
            return back()->with('newsletter_success', 'You are already subscribed.');
        }

        $confirmToken = Str::random(40);
        $unsubscribeToken = $subscription?->unsubscribe_token ?? Str::random(40);

        NewsletterSubscription::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? ($subscription?->name),
                'source' => $data['source'] ?? 'website',
                'is_active' => false,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
                'confirm_token' => $confirmToken,
                'confirmed_at' => null,
                'unsubscribe_token' => $unsubscribeToken,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        $confirmUrl = route('newsletter.confirm', ['token' => $confirmToken]);
        $unsubscribeUrl = route('newsletter.unsubscribe', ['token' => $unsubscribeToken]);
        Mail::to($data['email'])->send(new NewsletterConfirmMail($confirmUrl, $unsubscribeUrl));

        return back()->with('newsletter_success', 'Please check your email to confirm your subscription.');
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscription = NewsletterSubscription::where('confirm_token', $token)->first();
        if (!$subscription) {
            return redirect()->route('home')->with('newsletter_success', 'Invalid confirmation link.');
        }

        $subscription->update([
            'is_active' => true,
            'confirmed_at' => now(),
            'confirm_token' => null,
        ]);

        return redirect()->route('home')->with('newsletter_success', 'Subscription confirmed. Thank you!');
    }

    public function unsubscribe(string $token): RedirectResponse
    {
        $subscription = NewsletterSubscription::where('unsubscribe_token', $token)->first();
        if (!$subscription) {
            return redirect()->route('home')->with('newsletter_success', 'Invalid unsubscribe link.');
        }

        $subscription->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return redirect()->route('home')->with('newsletter_success', 'You have been unsubscribed.');
    }
}
