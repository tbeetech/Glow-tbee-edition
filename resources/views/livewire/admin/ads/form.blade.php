<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $isEditing ? 'Edit Ad' : 'Create Ad' }}</h3>
                <p class="text-sm text-gray-500">Manage jingles and ads shown across the site.</p>
            </div>
            <a href="{{ route('admin.ads.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left mr-2"></i>Back to Ads
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Placement</label>
                <select wire:model="placement"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="global">Global</option>
                    <option value="home">Homepage</option>
                    <option value="news">News</option>
                    <option value="blog">Blog</option>
                    <option value="shows">Shows</option>
                    <option value="contact">Contact</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select wire:model="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="image">Image</option>
                    <option value="html">HTML</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                <input type="number" wire:model="priority"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="md:col-span-2" x-data>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                <input type="text" wire:model.live.debounce.300ms="image_url"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @if($image_url)
                    <img src="{{ $image_url }}" alt="Preview" class="mt-3 w-full max-h-64 object-cover rounded-lg">
                @endif
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Custom HTML (for script embeds)</label>
                <textarea rows="4" wire:model="html"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                <input type="text" wire:model="link_url"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                <input type="text" wire:model="button_text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Starts At</label>
                <input type="datetime-local" wire:model="starts_at"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ends At</label>
                <input type="datetime-local" wire:model="ends_at"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="flex items-center space-x-2 text-sm text-gray-700">
                    <input type="checkbox" wire:model="is_active" class="rounded border-gray-300">
                    <span>Active</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button wire:click="save"
                class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg">
                {{ $isEditing ? 'Update Ad' : 'Create Ad' }}
            </button>
        </div>
    </div>
</div>
