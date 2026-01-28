<div>
    <section class="relative bg-gradient-to-br from-slate-700 via-slate-800 to-gray-900 text-white py-16">
        <div class="container mx-auto px-4">
            <x-ad-slot placement="oap-directory" />
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">OAP Directory</h1>
                <p class="text-lg md:text-xl text-slate-200">Meet the voices behind Glow FM.</p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-xl mx-auto mb-8">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.500ms="searchQuery"
                        placeholder="Search OAPs..."
                        class="w-full px-4 py-3 pr-10 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-slate-600 transition-colors">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            @if($oaps->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($oaps as $oap)
                        <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="relative w-16 h-16 rounded-full overflow-hidden">
                                        <x-initials-image
                                            :src="$oap->profile_photo"
                                            :title="$oap->name"
                                            imgClass="w-full h-full object-cover"
                                            fallbackClass="bg-slate-700/90"
                                            textClass="text-lg font-bold text-white"
                                        />
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 truncate">{{ $oap->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $oap->teamRole?->name ?? ($oap->employment_status ?? 'Broadcaster') }}</p>
                                        <p class="text-xs text-slate-500">{{ $oap->department?->name ?? 'General' }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 mt-4 line-clamp-3">{{ $oap->bio }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">{{ $oap->shows()->count() }} shows</span>
                                    <a href="{{ route('oaps.show', $oap->slug) }}"
                                        class="text-slate-600 hover:text-slate-800 text-sm font-semibold">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-10 flex justify-center">
                    {{ $oaps->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <i class="fas fa-user-circle text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No OAPs found</h3>
                    <p class="text-gray-600">Try a different search keyword.</p>
                </div>
            @endif
        </div>
    </section>
</div>
