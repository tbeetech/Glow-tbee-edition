<div class="min-h-screen bg-gray-50">
    <section class="relative bg-gradient-to-br from-emerald-700 via-emerald-800 to-slate-900 text-white py-16">
        <div class="container mx-auto px-4">
            <x-ad-slot placement="staff-detail" />
            <div class="max-w-4xl mx-auto">
                <nav class="flex items-center space-x-2 text-sm text-emerald-100 mb-6">
                    <a href="{{ route('staff.index') }}" class="hover:text-white">Team</a>
                    <span>›</span>
                    <span class="text-white">{{ $staff->name }}</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                    <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-white/40">
                        <x-initials-image
                            :src="$staff->photo_url"
                            :title="$staff->name"
                            imgClass="w-full h-full object-cover"
                            fallbackClass="bg-slate-700/90"
                            textClass="text-2xl font-bold text-white"
                        />
                    </div>
                    <div class="mt-4 md:mt-0">
                        <h1 class="text-4xl font-bold">{{ $staff->name }}</h1>
                        <p class="text-emerald-200 mt-2">{{ $staff->teamRole?->name ?? ($staff->role ?? 'Staff Member') }}</p>
                        <p class="text-sm text-emerald-100">{{ $staff->departmentRelation?->name ?? ($staff->department ?? 'General') }}</p>
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
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $staff->bio ?? 'No bio provided.' }}</p>
                    </div>
                </main>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Contact</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div><i class="fas fa-envelope mr-2 text-emerald-600"></i>{{ $staff->email ?? 'N/A' }}</div>
                            <div><i class="fas fa-phone mr-2 text-emerald-600"></i>{{ $staff->phone ?? 'N/A' }}</div>
                        </div>
                    </div>

                    @if(!empty($staff->social_links))
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="font-bold text-gray-900 mb-4">Social</h3>
                            <div class="flex flex-wrap gap-3 text-gray-500">
                                @foreach($staff->social_links as $key => $url)
                                    @if(!empty($url))
                                        <a href="{{ $url }}" target="_blank" rel="noopener"
                                            class="hover:text-emerald-600 transition-colors" aria-label="{{ ucfirst($key) }}">
                                            <i class="fab fa-{{ $key === 'linkedin' ? 'linkedin-in' : $key }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
</div>
