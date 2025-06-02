<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-[#011478]/10 to-transparent">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title with User Info -->
            <div class="mb-8 flex justify-between items-center bg-white/50 backdrop-blur-sm p-6 rounded-xl shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-[#011478]">Welcome to NextGenTradderAI</h2>
                    <div class="flex items-center mt-2 space-x-4">
                        <p class="text-gray-600 font-medium">Trader: {{ Auth::user()->name }}</p>
                        <span class="text-gray-400">|</span>
                        <p class="text-gray-600 font-medium">{{ now()->format('l, F j, Y') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-[#011478]/80">Trading Session</p>
                    <p class="text-lg font-mono">{{ now()->format('H:i:s') }} UTC</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm p-6">
                <!-- Dashboard Content -->
                @livewire('dashboard')
            </div>
        </div>
    </div>
</x-app-layout>