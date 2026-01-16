<div class="min-h-screen bg-gray-50">
    <section class="relative bg-gradient-to-br from-slate-700 via-slate-800 to-gray-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <nav class="flex items-center space-x-2 text-sm text-slate-200 mb-6">
                    <a href="{{ route('oaps.index') }}" class="hover:text-white">OAPs</a>
                    <span>›</span>
                    <span class="text-white">{{ $oap->name }}</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                    <img src="{{ $oap->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($oap->name) }}"
                        alt="{{ $oap->name }}" class="w-24 h-24 rounded-full border-2 border-white/40">
                    <div class="mt-4 md:mt-0">
                        <h1 class="text-4xl font-bold">{{ $oap->name }}</h1>
                        <p class="text-slate-200 mt-2">{{ $oap->employment_status ?? 'Broadcaster' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <main class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Bio</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $oap->bio }}</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-8 mt-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Shows</h2>
                        <div class="space-y-4">
                            @forelse($oap->shows as $show)
                                <div class="p-4 bg-gray-50 rounded-xl">
                                    <p class="text-sm text-gray-500">{{ $show->category?->name ?? 'Show' }}</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        <a href="{{ route('shows.show', $show->slug) }}" class="hover:text-slate-700">
                                            {{ $show->title }}
                                        </a>
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $show->description }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">No shows assigned yet.</p>
                            @endforelse
                        </div>
                    </div>
                </main>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Contact</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div><i class="fas fa-envelope mr-2 text-slate-600"></i>{{ $oap->email ?? 'N/A' }}</div>
                            <div><i class="fas fa-phone mr-2 text-slate-600"></i>{{ $oap->phone ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Specializations</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(($oap->specializations ?? []) as $spec)
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs">{{ $spec }}</span>
                            @endforeach
                            @if(empty($oap->specializations))
                                <span class="text-sm text-gray-500">No specializations listed.</span>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>
