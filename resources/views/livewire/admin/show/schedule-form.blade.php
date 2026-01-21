<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $isEditing ? 'Edit Schedule Slot' : 'Add Schedule Slot' }}</h3>
                <p class="text-sm text-gray-500">Plan weekly programming slots.</p>
            </div>
            <a href="{{ route('admin.shows.schedule') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                <i class="fas fa-arrow-left mr-2"></i>Back to Schedule
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Show</label>
                <select wire:model="schedule_show_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Select show</option>
                    @foreach($allShows as $show)
                        <option value="{{ $show->id }}">{{ $show->title }}</option>
                    @endforeach
                </select>
                @error('schedule_show_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">OAP</label>
                <select wire:model="schedule_oap_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Select OAP</option>
                    @foreach($allOaps as $oap)
                        <option value="{{ $oap->id }}">{{ $oap->name }}</option>
                    @endforeach
                </select>
                @error('schedule_oap_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Frequency</label>
                <select wire:model="schedule_recurrence_type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="selected">Selected Days</option>
                </select>
                @error('schedule_recurrence_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                @if($isEditing)
                    <p class="mt-1 text-xs text-amber-600">Changing frequency will replace this slot with new days.</p>
                @endif
            </div>
            @if($schedule_recurrence_type === 'weekly')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Day</label>
                    <select wire:model="schedule_day_of_week"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        @foreach($daysOfWeek as $day)
                            <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                        @endforeach
                    </select>
                    @error('schedule_day_of_week') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @elseif($schedule_recurrence_type === 'selected')
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Days</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($daysOfWeek as $day)
                            <label class="flex items-center space-x-2 text-sm text-gray-700">
                                <input type="checkbox" wire:model="schedule_days" value="{{ $day }}"
                                    class="rounded border-gray-300">
                                <span>{{ ucfirst($day) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('schedule_days') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endif
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start</label>
                    <input type="time" wire:model="schedule_start_time"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @error('schedule_start_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End</label>
                    <input type="time" wire:model="schedule_end_time"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @error('schedule_end_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" wire:model="schedule_start_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" wire:model="schedule_end_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model="schedule_status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
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
                <textarea rows="3" wire:model="schedule_notes"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.shows.schedule') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                Cancel
            </a>
            <button wire:click="save"
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                {{ $isEditing ? 'Update Schedule' : 'Create Schedule' }}
            </button>
        </div>
    </div>
</div>
