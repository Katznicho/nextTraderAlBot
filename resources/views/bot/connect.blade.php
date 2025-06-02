<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Connect Your Trading Bot</h2>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Bot Configuration Status</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">Platform:</span> {{ $botConfig->platform }}
                        </div>
                        <div>
                            <span class="font-medium">Account ID:</span> {{ $botConfig->account_id }}
                        </div>
                        <div>
                            <span class="font-medium">Server:</span> {{ $botConfig->server }}
                        </div>
                        <div>
                            <span class="font-medium">Status:</span> 
                            <span class="{{ $botConfig->connection_status === 'connected' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($botConfig->connection_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('bot.connect.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#011478] hover:bg-[#011478]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#011478]">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Connect Bot
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>