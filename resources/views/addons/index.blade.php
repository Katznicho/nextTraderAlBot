<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Enhance Your Bot with Add-ons</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($addons as $addon)
                <div
                    class="bg-white shadow rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-700">{{ $addon->name }}</h3>
                        <span class="text-green-600 font-bold">${{ number_format($addon->price, 2) }}</span>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">{{ $addon->description }}</p>

                    <ul class="text-sm text-gray-700 space-y-1 mb-4">
                        @foreach ($addon->features as $feature)
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('addons.activate', $addon->id) }}" method="POST">
                    <button
                        class="w-full bg-indigo-600 text-white text-sm font-semibold py-2 rounded hover:bg-indigo-700 transition">
                        Activate Add-on
                    </button>
                    @csrf
                </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
