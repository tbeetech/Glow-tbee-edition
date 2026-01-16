<div>
    <section class="relative bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Weekly Schedule</h1>
                <p class="text-lg md:text-xl text-emerald-100">Your weekly guide to every show on Glow FM.</p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($scheduleByDay as $day => $slots)
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ ucfirst($day) }}</h3>
                        <div class="space-y-4">
                            @forelse($slots as $slot)
                                <div class="flex items-start justify-between gap-4 p-4 bg-gray-50 rounded-xl">
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $slot->time_range }}</p>
                                        <p class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('shows.show', $slot->show->slug) }}" class="hover:text-emerald-600">
                                                {{ $slot->show->title }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $slot->oap?->name ?? 'Host TBA' }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">
                                        {{ ucfirst($slot->show->format) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No shows scheduled.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
