<div class="space-y-6" wire:poll.1000ms>
    {{-- @if($showFreezeWarning)
    <div class="bg-red-50 dark:bg-red-900/50 border-l-4 border-red-500 p-4 rounded-r-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                    Account Freeze Warning
                </h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <p>Your account balance is $0. Please deposit funds to prevent account freeze.</p>
                    <p class="mt-1 font-medium">Time remaining until freeze: 
                        <span class="text-red-600 dark:text-red-400 font-mono">{{ $this->formattedCountdown }}</span>
                    </p>
                </div>
                <div class="mt-4">
                    <div class="-mx-2 -my-1.5 flex">
                        <button type="button" class="bg-red-50 dark:bg-red-900/30 px-3 py-2 rounded-md text-sm font-medium text-red-800 dark:text-red-200 hover:bg-red-100 dark:hover:bg-red-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                            Deposit Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif --}}

    @if(!$userPlan)
    <div class="bg-yellow-50 dark:bg-yellow-900/50 border-l-4 border-yellow-500 p-4 rounded-r-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
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
                    <div class="-mx-2 -my-1.5 flex">
                        <button type="button" class="bg-yellow-50 dark:bg-yellow-900/30 px-3 py-2 rounded-md text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600" onclick="window.location.href='/subscriptions'">
                            Subscribe Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    <!-- Trading Account Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Balance Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Balance</h3>
                <span class="text-xs text-gray-400">Last Update: {{ $lastUpdate }}</span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-[#011478] dark:text-white">${{ number_format($balance, 2) }}</span>
                <span class="ml-2 text-sm text-gray-500">USD</span>
            </div>
        </div>

        <!-- Profit/Loss Card -->
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

        <!-- Total Trades Card -->
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

        <!-- Trading Status Card -->
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

    <!-- Trading Chart Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Trading Performance</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-sm bg-[#011478]/10 text-[#011478] rounded-lg">1H</button>
                <button class="px-3 py-1 text-sm bg-[#011478]/10 text-[#011478] rounded-lg">1D</button>
                <button class="px-3 py-1 text-sm bg-[#011478]/10 text-[#011478] rounded-lg">1W</button>
                <button class="px-3 py-1 text-sm bg-[#011478]/10 text-[#011478] rounded-lg">1M</button>
            </div>
        </div>
        <div class="h-[600px] w-full" id="tradingview_chart" wire:ignore>
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
                <div id="{{ $chartId }}" style="height: 100%; width: 100%;"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                document.addEventListener('livewire:initialized', function () {
                    let widget = null;
                    
                    function initWidget() {
                        if (widget) {
                            widget.remove();
                        }
                        
                        widget = new TradingView.widget({
                            "width": "100%",
                            "height": "100%",
                            "symbol": "BINANCE:BTCUSDT",
                            "interval": "D",
                            "timezone": "Etc/UTC",
                            "theme": "dark",
                            "style": "1",
                            "locale": "en",
                            "toolbar_bg": "#f1f3f6",
                            "enable_publishing": false,
                            "hide_side_toolbar": false,
                            "allow_symbol_change": true,
                            "container_id": "{{ $chartId }}"
                        });
                    }
                
                    initWidget();
                    
                    Livewire.on('refreshChart', () => {
                        initWidget();
                    });
                });
                </script>
            </div>
            <!-- TradingView Widget END -->
        </div>
    </div>

    <!-- Top Trading Pairs & Indicators Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Trading Pairs -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top Trading Pairs</h3>
            <div class="space-y-4">
                @foreach($topPairs as $pair)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $pair['pair'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">${{ $pair['price'] }}</span>
                            <span class="text-sm font-medium {{ str_starts_with($pair['change'], '+') ? 'text-green-500' : 'text-red-500' }}">
                                {{ $pair['change'] }}%
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Trading Indicators -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Trading Indicators</h3>
            <div class="space-y-4">
                @foreach($indicators as $indicator)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $indicator['name'] }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">{{ $indicator['value'] }}</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                $indicator['signal'] === 'Buy' || $indicator['signal'] === 'Strong Buy' ? 'bg-green-100 text-green-800' :
                                ($indicator['signal'] === 'Sell' || $indicator['signal'] === 'Strong Sell' ? 'bg-red-100 text-red-800' :
                                'bg-gray-100 text-gray-800') 
                            }}">{{ $indicator['signal'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Trades Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Trades</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pair</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="text-sm text-gray-500 dark:text-gray-400">
                        <td class="px-6 py-4">No trades yet</td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add this script section at the bottom of your blade file -->
@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        let countdownInterval;
        
        Livewire.on('startCountdown', () => {
            clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                @this.freezeCountdown--;
                if (@this.freezeCountdown <= 0) {
                    clearInterval(countdownInterval);
                    // Handle account freeze
                }
            }, 1000);
        });

        if (@this.showFreezeWarning) {
            Livewire.emit('startCountdown');
        }
    });
</script>
@endpush

