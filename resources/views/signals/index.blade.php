<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">📈 Premium Signals Marketplace</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($signals as $signal)
                <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $signal->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $signal->description }}</p>

                        <ul class="text-sm text-gray-700 space-y-1 mb-4">
                            @foreach($signal->features as $feature)
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-green-500 mt-1 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <div class="flex items-center justify-between mt-6">
                            <span class="text-xl font-semibold text-indigo-600">
                                ${{ number_format($signal->price, 2) }}/mo
                            </span>
                            <form action="{{ route('signals.subscribe', $signal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($signals->isEmpty())
            <div class="text-center text-gray-500 mt-10">No premium signals available at the moment.</div>
        @endif
    </div>
</x-app-layout>
