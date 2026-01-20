<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-{{ $accent }}-100 rounded-xl flex items-center justify-center">
                    <i class="{{ $icon }} text-{{ $accent }}-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-xl font-semibold text-gray-900">{{ $title }}</p>
                    <p class="text-sm text-gray-600">{{ $subtitle }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $accent }}-100 text-{{ $accent }}-700">
                    Coming soon
                </span>
                <button class="px-4 py-2 text-sm font-semibold rounded-lg bg-{{ $accent }}-600 text-white hover:bg-{{ $accent }}-700 transition-colors">
                    Configure
                </button>
            </div>
        </div>
        <p class="text-sm text-gray-600 mt-4">{{ $description }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-2">At a glance</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Total records</span>
                    <span class="text-sm font-semibold text-gray-900">0</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Last 7 days</span>
                    <span class="text-sm font-semibold text-gray-900">0</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">Needs review</span>
                    <span class="text-sm font-semibold text-gray-900">0</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-2">Next steps</p>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-{{ $accent }}-600 mr-2"></i>
                    Connect the data source
                </li>
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-{{ $accent }}-600 mr-2"></i>
                    Define tracking fields
                </li>
                <li class="flex items-center">
                    <i class="fas fa-check-circle text-{{ $accent }}-600 mr-2"></i>
                    Set review workflow
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600 mb-2">Notes</p>
            <div class="text-sm text-gray-700 space-y-2">
                <p>No data is configured yet.</p>
                <p>Use this page to manage community operations once connected.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent activity</h3>
            <span class="text-xs text-gray-500">No events yet</span>
        </div>
        <div class="border border-dashed border-gray-200 rounded-lg p-6 text-center text-sm text-gray-500">
            Activity will appear here once data starts flowing.
        </div>
    </div>
</div>
