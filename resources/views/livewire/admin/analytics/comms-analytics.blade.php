<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Total Contact Messages</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['contact_total'] }}</p>
            <p class="text-xs text-gray-500 mt-2">Unread: {{ $stats['contact_unread'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Replies Sent</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $stats['contact_replied'] }}</p>
            <p class="text-xs text-gray-500 mt-2">Status: replied</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Newsletter Subscribers</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['newsletter_active'] }}</p>
            <p class="text-xs text-gray-500 mt-2">Pending: {{ $stats['newsletter_pending'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Messages</h3>
            <div class="space-y-4">
                @forelse($recentMessages as $message)
                    <div class="border-b border-gray-200 pb-3">
                        <p class="text-sm font-semibold text-gray-900">{{ $message->subject }}</p>
                        <p class="text-xs text-gray-500">{{ $message->name }} • {{ $message->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No messages yet.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Subscribers</h3>
            <div class="space-y-4">
                @forelse($recentSubscribers as $subscriber)
                    <div class="border-b border-gray-200 pb-3">
                        <p class="text-sm font-semibold text-gray-900">{{ $subscriber->email }}</p>
                        <p class="text-xs text-gray-500">{{ $subscriber->subscribed_at?->diffForHumans() ?? '—' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No subscribers yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
