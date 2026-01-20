<div>
    <section class="relative bg-gradient-to-br from-emerald-700 via-emerald-800 to-slate-900 text-white py-16">
        <div class="container mx-auto px-4">
            <x-ad-slot placement="staff-directory" />
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Staff Directory</h1>
                <p class="text-lg md:text-xl text-emerald-100">Meet the people powering Glow FM behind the scenes.</p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-xl mx-auto mb-8">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.500ms="searchQuery"
                        placeholder="Search staff..."
                        class="w-full px-4 py-3 pr-10 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-emerald-600 transition-colors">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            @if($staffProfiles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($staffProfiles as $staff)
                        <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden">
                                        @if($staff['photo'])
                                            <img src="{{ $staff['photo'] }}" alt="{{ $staff['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-emerald-600 text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 truncate">
                                            <a href="{{ $staff['profile_url'] }}" class="hover:text-emerald-700">
                                                {{ $staff['name'] }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $staff['role'] }}</p>
                                        <p class="text-xs text-emerald-600">{{ $staff['department'] }}</p>
                                    </div>
                                </div>

                                @if($staff['bio'])
                                    <p class="text-gray-600 mt-4 line-clamp-3">{{ $staff['bio'] }}</p>
                                @endif

                                <div class="mt-4 space-y-2 text-sm text-gray-600">
                                    @if($staff['email'])
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-envelope text-emerald-500"></i>
                                            <span>{{ $staff['email'] }}</span>
                                        </div>
                                    @endif
                                    @if($staff['phone'])
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-phone text-emerald-500"></i>
                                            <span>{{ $staff['phone'] }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if(!empty($staff['social_links']))
                                    <div class="mt-4 flex items-center space-x-3 text-gray-400">
                                        @foreach($staff['social_links'] as $key => $url)
                                            @if(!empty($url))
                                                <a href="{{ $url }}" target="_blank" rel="noopener"
                                                    class="hover:text-emerald-600 transition-colors" aria-label="{{ ucfirst($key) }}">
                                                    <i class="fab fa-{{ $key === 'linkedin' ? 'linkedin-in' : $key }}"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-10 flex justify-center">
                    {{ $staffProfiles->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <i class="fas fa-user-circle text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No staff found</h3>
                    <p class="text-gray-600">Try a different search keyword.</p>
                </div>
            @endif
        </div>
    </section>
</div>
