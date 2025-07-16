<div wire:poll.1000ms x-data="{ isModalOpen: false }" x-cloak class="space-y-6">

    {{-- Subscription Notice --}}
    @if (!$userPlan)
        <div class="bg-yellow-50 dark:bg-yellow-900/50 border-l-4 border-yellow-500 p-4 rounded-r-xl">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        Subscription Required
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>You currently have no active subscription plan. Please subscribe to access premium features.</p>
                    </div>
                    <div class="mt-4">
                        <button type="button"
                            onclick="window.location.href='/subscriptions'"
                            class="bg-yellow-50 dark:bg-yellow-900/30 px-3 py-2 rounded-md text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 focus:outline-none">
                            Subscribe Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Account Overview Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Balance --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Balance</h3>
                <span class="text-xs text-gray-400">Last Update: {{ $lastUpdate }}</span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-[#011478] dark:text-white">${{ number_format($balance, 2) }}</span>
                <span class="ml-2 text-sm text-gray-500">USD</span>
            </div>
            @if ($balance > 20)
                <div class="mt-4">
                    <button type="button"
                        x-on:click="isModalOpen = true"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Withdraw Funds
                    </button>
                </div>
            @endif
        </div>

        {{-- Profit / Loss --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Profit/Loss</h3>
                <span class="text-xs text-gray-400">24h Change</span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold {{ $profitLoss >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $profitLoss >= 0 ? '+' : '' }}${{ number_format($profitLoss, 2) }}
                </span>
                <span class="ml-2 text-sm text-gray-500">USD</span>
            </div>
        </div>

        {{-- Total Trades --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Trades</h3>
                <span class="text-xs text-gray-400">All Time</span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-[#011478] dark:text-white">{{ number_format($totalTrades) }}</span>
                <span class="ml-2 text-sm text-gray-500">trades</span>
            </div>
        </div>

        {{-- Bot Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Bot Status</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $userPlan ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $userPlan ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="text-sm text-gray-500">
                NextGenHunterAI is {{ $userPlan ? 'actively monitoring markets' : 'not monitoring markets due to inactive subscription' }}
            </div>
        </div>
    </div>

    {{-- TradingView Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Trading Pairs</h3>
        </div>
        <div class="h-[600px] w-full" id="tradingview_chart" wire:ignore>
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <div class="tradingview-widget-copyright">
                    <a href="https://www.tradingview.com/" target="_blank" rel="noopener nofollow">
                        <span class="blue-text">Track all markets on TradingView</span>
                    </a>
                </div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js" async>
                {
                    "width": "100%",
                    "height": "100%",
                    "currencies": ["EUR","USD","JPY","GBP","CHF","AUD","CAD","NZD"],
                    "colorTheme": "light",
                    "locale": "en",
                    "backgroundColor": "#fff"
                }
                </script>
            </div>
        </div>
    </div>

    {{-- Top Trading Pairs and Recent Trades --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Pairs --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top Trading Pairs</h3>
            <div class="space-y-4">
                @foreach ($topPairs as $pair)
                    <div class="flex items-center justify-between py-2 border-b dark:border-gray-700 last:border-0">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $pair['pair'] }}</span>
                        <div class="flex space-x-4">
                            <span class="text-sm text-gray-900 dark:text-white">${{ $pair['price'] }}</span>
                            <span class="text-sm {{ str_starts_with($pair['change'], '+') ? 'text-green-500' : 'text-red-500' }}">
                                {{ $pair['change'] }}%
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Trades --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Trades</h3>
            <div class="space-y-4">
                @foreach ($recentTrades as $trade)
                    <div class="flex justify-between py-2 border-b dark:border-gray-700 last:border-0">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $trade['pair'] }}</span>
                            <span class="text-xs text-gray-500">{{ $trade['time'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $trade['side'] === 'Buy' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $trade['side'] }}
                            </span>
                            <span class="text-sm font-mono text-gray-800 dark:text-gray-200">{{ $trade['price'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Withdrawal Modal --}}
    <div x-show="isModalOpen" 
     class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm p-4" 
     x-cloak>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow w-full max-w-md relative">
        <div class="flex justify-between items-center p-4 border-b dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Withdraw Funds</h3>
            <button x-on:click="isModalOpen = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
        <div class="p-4">
            <form wire:submit.prevent="submitWithdrawal">
                <div class="mb-4">
                    <label class="block text-sm text-gray-700 dark:text-white">Amount (USD)</label>
                    <input type="number" wire:model="withdrawalAmount" min="20" step="0.01"
                        class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white"/>
                    @error('withdrawalAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-700 dark:text-white">Wallet Address</label>
                    <input type="text" wire:model="cryptoAddress"
                        class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white"/>
                    @error('cryptoAddress') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-700 dark:text-white">Cryptocurrency</label>
                    <select wire:model="cryptoCurrency"
                        class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                        <option value="">Select</option>
                        <option value="BTC">Bitcoin</option>
                        <option value="ETH">Ethereum</option>
                        <option value="USDT">Tether</option>
                    </select>
                    @error('cryptoCurrency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                    Submit Withdrawal
                </button>
            </form>
        </div>
    </div>
</div>

    {{-- Withdrawal Modal --}}

</div>
