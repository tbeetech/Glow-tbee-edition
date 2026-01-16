<div>
    <!-- Tabs -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.shows.index') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $view === 'shows' ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Shows
            </a>
            <a href="{{ route('admin.shows.oaps') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $view === 'oaps' ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                OAPs
            </a>
            <a href="{{ route('admin.shows.schedule') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $view === 'schedule' ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Schedule
            </a>
            <a href="{{ route('admin.shows.segments') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $view === 'segments' ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Segments
            </a>
            <a href="{{ route('admin.shows.categories') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $view === 'categories' ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                Categories
            </a>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Search..."
                    class="w-full sm:w-64 pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <button wire:click="openModal('{{ $view === 'oaps' ? 'oap' : ($view === 'categories' ? 'category' : ($view === 'schedule' ? 'schedule' : ($view === 'segments' ? 'segment' : 'show'))) }}')"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg">
                <i class="fas fa-plus mr-2"></i>
                Add {{ $view === 'oaps' ? 'OAP' : ($view === 'categories' ? 'Category' : ($view === 'schedule' ? 'Slot' : ($view === 'segments' ? 'Segment' : 'Show'))) }}
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-1">Total Shows</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_shows'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-1">Active Shows</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $stats['active_shows'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-1">Total OAPs</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_oaps'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-1">Categories</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
        </div>
    </div>

    <!-- Shows -->
    @if($view === 'shows')
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($shows as $show)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="h-40 bg-gray-100 overflow-hidden">
                        @if($show->cover_image)
                            <img src="{{ $show->cover_image }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $show->title }}</h3>
                            @if($show->is_featured)
                                <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-full">Featured</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $show->description }}</p>
                        <div class="mt-3 text-xs text-gray-500 space-y-1">
                            <div><i class="fas fa-layer-group mr-1"></i>{{ $show->category?->name ?? 'Uncategorized' }}</div>
                            <div><i class="fas fa-user mr-1"></i>{{ $show->primaryHost?->name ?? 'TBA' }}</div>
                            <div><i class="fas fa-clock mr-1"></i>{{ $show->typical_duration }} mins • {{ ucfirst($show->format) }}</div>
                        </div>
                        <div class="mt-4 flex items-center justify-end space-x-2">
                            <button wire:click="openModal('show', {{ $show->id }})" class="text-emerald-600 hover:text-emerald-900">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="delete('show', {{ $show->id }})" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center text-gray-500">
                    No shows found.
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $shows->links() }}</div>
    @endif

    <!-- OAPs -->
    @if($view === 'oaps')
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($oaps as $oap)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $oap->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($oap->name) }}"
                            class="w-12 h-12 rounded-full">
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $oap->name }}</p>
                            <p class="text-xs text-gray-500">{{ $oap->employment_status ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $oap->bio }}</p>
                    <div class="mt-4 flex items-center justify-end space-x-2">
                        <button wire:click="openModal('oap', {{ $oap->id }})" class="text-emerald-600 hover:text-emerald-900">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button wire:click="delete('oap', {{ $oap->id }})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center text-gray-500">
                    No OAPs found.
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $oaps->links() }}</div>
    @endif

    <!-- Schedule -->
    @if($view === 'schedule')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Show</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">OAP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($scheduleSlots as $slot)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($slot->day_of_week) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $slot->time_range }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $slot->show->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $slot->oap?->name ?? 'TBA' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $slot->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($slot->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <button wire:click="openModal('schedule', {{ $slot->id }})" class="text-emerald-600 hover:text-emerald-900 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete('schedule', {{ $slot->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">No schedule slots found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $scheduleSlots->links() }}
            </div>
        </div>
    @endif

    <!-- Segments -->
    @if($view === 'segments')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Show</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($segments as $segment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $segment->show->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $segment->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $segment->time_range }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($segment->type) }}</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <button wire:click="openModal('segment', {{ $segment->id }})" class="text-emerald-600 hover:text-emerald-900 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete('segment', {{ $segment->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">No segments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $segments->links() }}
            </div>
        </div>
    @endif

    <!-- Categories -->
    @if($view === 'categories')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shows</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-{{ $category->color }}-100">
                                            <i class="{{ $category->icon }} text-{{ $category->color }}-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $category->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $category->shows_count }}</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <button wire:click="openModal('category', {{ $category->id }})" class="text-emerald-600 hover:text-emerald-900 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete('category', {{ $category->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        </div>
    @endif

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-6 py-5">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ $editMode ? 'Edit' : 'Create' }}
                            {{ $modalType === 'oap' ? 'OAP' : ($modalType === 'category' ? 'Category' : ($modalType === 'schedule' ? 'Schedule Slot' : ($modalType === 'segment' ? 'Segment' : 'Show'))) }}
                        </h3>

                        @if($modalType === 'show')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                    <input type="text" wire:model="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea wire:model="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select wire:model="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Select category</option>
                                        @foreach($allCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Host</label>
                                    <select wire:model="primary_host_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Select OAP</option>
                                        @foreach($allOaps as $oap)
                                            <option value="{{ $oap->id }}">{{ $oap->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                                    <select wire:model="format" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="live">Live</option>
                                        <option value="pre-recorded">Pre-recorded</option>
                                        <option value="hybrid">Hybrid</option>
                                        <option value="automated">Automated</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (mins)</label>
                                    <input type="number" wire:model="typical_duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Content Rating</label>
                                    <select wire:model="content_rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="G">G</option>
                                        <option value="PG">PG</option>
                                        <option value="PG-13">PG-13</option>
                                        <option value="18+">18+</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                    <input type="text" wire:model="tags" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="music, talk, news">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                                    <input type="file" wire:model="cover_image" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <input type="url" wire:model="cover_url" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="https://example.com/image.jpg">
                                </div>
                                <div class="md:col-span-2 flex items-center space-x-2">
                                    <input type="checkbox" wire:model="is_featured" class="rounded border-gray-300">
                                    <span class="text-sm text-gray-700">Featured show</span>
                                </div>
                            </div>
                        @elseif($modalType === 'oap')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" wire:model="oap_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    @error('oap_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                    <textarea wire:model="oap_bio" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                    @error('oap_bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" wire:model="oap_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="text" wire:model="oap_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                                    <input type="text" wire:model="oap_specializations" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="news, sports, music">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                                    <input type="file" wire:model="oap_photo" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <input type="url" wire:model="oap_photo_url" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="https://example.com/photo.jpg">
                                </div>
                            </div>
                        @elseif($modalType === 'category')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" wire:model="cat_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    @error('cat_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea wire:model="cat_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                                    <input type="text" wire:model="cat_icon" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                                    <input type="text" wire:model="cat_color" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        @elseif($modalType === 'schedule')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Show</label>
                                    <select wire:model="schedule_show_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Select show</option>
                                        @foreach($allShows as $show)
                                            <option value="{{ $show->id }}">{{ $show->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('schedule_show_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">OAP</label>
                                    <select wire:model="schedule_oap_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Select OAP</option>
                                        @foreach($allOaps as $oap)
                                            <option value="{{ $oap->id }}">{{ $oap->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('schedule_oap_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Day</label>
                                    <select wire:model="schedule_day_of_week" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                                            <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Start</label>
                                        <input type="time" wire:model="schedule_start_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        @error('schedule_start_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">End</label>
                                        <input type="time" wire:model="schedule_end_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        @error('schedule_end_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="date" wire:model="schedule_start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="date" wire:model="schedule_end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select wire:model="schedule_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="active">Active</option>
                                        <option value="paused">Paused</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2 mt-6">
                                    <input type="checkbox" wire:model="schedule_is_recurring" class="rounded border-gray-300">
                                    <span class="text-sm text-gray-700">Recurring weekly</span>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                    <textarea wire:model="schedule_notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                </div>
                            </div>
                        @elseif($modalType === 'segment')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Show</label>
                                    <select wire:model="segment_show_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Select show</option>
                                        @foreach($allShows as $show)
                                            <option value="{{ $show->id }}">{{ $show->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('segment_show_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                                    <select wire:model="segment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        @foreach(['intro','interview','music','news','ads','calls','outro','other'] as $type)
                                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                    <input type="text" wire:model="segment_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    @error('segment_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea wire:model="segment_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Minute</label>
                                    <input type="number" wire:model="segment_start_minute" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (mins)</label>
                                    <input type="number" wire:model="segment_duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
                        <button wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">Cancel</button>
                        <button wire:click="save" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                            {{ $editMode ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
