<?php

namespace App\Livewire\Admin\Analytics;

use App\Models\ContactMessage;
use App\Models\NewsletterSubscription;
use Livewire\Component;

class CommsAnalytics extends Component
{
    public function getStatsProperty()
    {
        return [
            'contact_total' => ContactMessage::count(),
            'contact_unread' => ContactMessage::where('is_read', false)->count(),
            'contact_replied' => ContactMessage::where('status', 'replied')->count(),
            'newsletter_total' => NewsletterSubscription::count(),
            'newsletter_active' => NewsletterSubscription::where('is_active', true)->count(),
            'newsletter_pending' => NewsletterSubscription::whereNull('confirmed_at')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.analytics.comms-analytics', [
            'stats' => $this->stats,
            'recentMessages' => ContactMessage::latest()->limit(5)->get(),
            'recentSubscribers' => NewsletterSubscription::latest()->limit(5)->get(),
        ])->layout('layouts.admin', ['header' => 'Comms Analytics']);
    }
}
