<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $isEditing ? 'Edit Segment' : 'Add Segment' }}</h3>
                <p class="text-sm text-gray-500">Define segments within a show.</p>
            </div>
            <a href="{{ route('admin.shows.segments') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left mr-2"></i>Back to Segments
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Show</label>
                <select wire:model="segment_show_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Select show</option>
                    @foreach($allShows as $show)
                        <option value="{{ $show->id }}">{{ $show->title }}</option>
                    @endforeach
                </select>
                @error('segment_show_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select wire:model="segment_type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @foreach(['intro','interview','music','news','ads','calls','outro','other'] as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" wire:model="segment_title"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('segment_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea rows="3" wire:model="segment_description"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                <input type="time" wire:model="segment_start_time"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <p class="mt-1 text-xs text-gray-500">Use standard time format (e.g., 09:30).</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Duration (mins)</label>
                <input type="number" wire:model="segment_duration"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.shows.segments') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                Cancel
            </a>
            <button wire:click="save"
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                {{ $isEditing ? 'Update Segment' : 'Create Segment' }}
            </button>
        </div>
    </div>
</div>
