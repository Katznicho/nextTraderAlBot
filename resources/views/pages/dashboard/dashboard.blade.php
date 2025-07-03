<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-[#011478]/10 to-transparent">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title with User Info -->
            <div class="mb-8 flex justify-between items-center bg-white/50 backdrop-blur-sm p-6 rounded-xl shadow-sm">
                <div>
                    <h2 class="text-3xl font-bold text-[#011478]">Welcome to NextGenTraderAI</h2>
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

            <!-- Telegram Banner -->
            <div 
                x-data="{ showBanner: true }" 
                x-show="showBanner" 
                x-transition 
                class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 flex justify-between items-center shadow-sm"
            >
                <div class="flex items-center space-x-4">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.001 14.314l-.36 3.753c.516 0 .738-.222 1.011-.488l2.419-2.273 5.011 3.668c.918.507 1.577.241 1.806-.849l3.271-15.288c.331-1.572-.567-2.184-1.585-1.806l-19.155 7.38c-1.303.507-1.286 1.239-.222 1.569l4.91 1.532 11.39-7.167-9.497 8.469z"/>
                    </svg>
                    <p class="text-sm font-medium">
                        Join our <a href="https://t.me/nextgentradenetwork" target="_blank" class="underline hover:text-blue-600 font-semibold">Telegram community</a> to connect with other AI traders and get the latest updates!
                    </p>
                </div>
                <button @click="showBanner = false" class="text-blue-500 hover:text-blue-700 text-xl font-bold ml-4">&times;</button>
            </div>

            <!-- Main Content -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm p-6">
                @livewire('dashboard')
            </div>
        </div>
    </div>
</x-app-layout>
