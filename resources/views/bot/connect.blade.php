<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Connected Bot View --}}
        @if ($botConfig->connection_status === 'connected')
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-10">
                <h3 class="text-lg font-medium text-green-800 mb-4">Connected Bot Details</h3>

                {{-- Bot Image --}}
                @if ($botConfig->image_url)
                    <div class="flex justify-center mb-6">
                        <img src="{{ $botConfig->image_url }}" alt="Bot Image"
                            class="w-40 h-40 object-cover rounded-full border-2 border-green-400 shadow">
                    </div>
                @endif

                {{-- Bot Details --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800">
                    <div><span class="font-semibold">Broker :</span> {{ strtoupper($botConfig->account_id) }}</div>
                    <div><span class="font-semibold">Platform:</span> {{ strtoupper($botConfig->platform) }}</div>
                    <div><span class="font-semibold">Login:</span> {{ $botConfig->login }}</div>
                    <div><span class="font-semibold">Password:</span> {{ $botConfig->password }}</div>
                    <div><span class="font-semibold">Server:</span> {{ $botConfig->server }}</div>
                    <div>
                        <span class="font-semibold">Connection Status:</span>
                        <span class="text-green-600">{{ ucfirst($botConfig->connection_status) }}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Bot Credits:</span>
                        <span class="{{ $botConfig->fuel_balance == 0 ? 'text-red-600 font-bold' : 'text-green-700' }}">
                            {{ $botConfig->fuel_balance }}
                        </span>
                    </div>
                </div>

                {{-- Warning if fuel is 0 --}}
                @if ($botConfig->fuel_balance == 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Deposit to Your Trading Account</h3>
                        <div class="p-4 bg-red-100 border border-red-300 rounded">
                            <p class="text-red-700 font-medium">
                                ⚠️ Your bot has 0 Bot Credits. Please deposit to your bot to start trading.
                            </p>
                            @if ($botConfig->current_strategy === 'in_app')
                                <form action="{{ route('bot.deposit') }}" method="GET" class="mt-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                        Deposit to your bot to start trading
                                    </button>
                                </form>
                                <p class="mt-2 text-blue-700 text-sm font-medium">
                                    This bot uses the in-app strategy. Please deposit to enable trading.
                                </p>
                            @else
                                <form action="{{ route('bot.fuel') }}" method="GET" class="mt-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                        Deposit to your bot to start trading
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- Non-connected bot statuses --}}
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-10">
                <h3 class="text-lg font-medium text-yellow-800 mb-2">Bot Configuration Status</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800">
                    <div><span class="font-semibold">Platform:</span> {{ $botConfig->platform }}</div>
                    <div><span class="font-semibold">Broker:</span> {{ $botConfig->account_id }}</div>
                    <div><span class="font-semibold">Server:</span> {{ $botConfig->server }}</div>
                    <div>
                        <span class="font-semibold">Connection Status:</span>
                        <span class="text-red-600">{{ ucfirst($botConfig->connection_status) }}</span>
                    </div>
                </div>

                <div class="mt-4 text-sm text-yellow-700">
                    {{-- Optional extra message based on status --}}
                    @if ($botConfig->connection_status === 'pending')
                        <p>⏳ Your bot is currently pending connection. Please wait...</p>
                    @elseif ($botConfig->connection_status === 'disconnected')
                        <p>⚠️ Your bot is disconnected. Please reconnect or check your credentials.</p>
                    @else
                        <p>ℹ️ Status: {{ ucfirst($botConfig->connection_status) }}</p>
                    @endif
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
