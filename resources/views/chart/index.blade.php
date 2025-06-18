@php
    $isAdmin = auth()->user()->user_type === 'Admin';
    $chartId = 'tradingview_chart_container';
@endphp

<x-app-layout>
    <div class="max-w-7xl mx-auto py-1 px-1">
        <!-- Trading Performance Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Market Overview
                </h3>
                <div class="flex gap-2">
                    {{-- @foreach (['1H', '1D', '1W', '1M'] as $interval)
                        <button class="px-3 py-1 text-sm font-medium bg-[#011478]/10 text-[#011478] rounded-lg hover:bg-[#011478]/20 transition">
                            {{ $interval }}
                        </button>
                    @endforeach --}}
                </div>
            </div>

            <!-- TradingView Chart Widget -->
            <div class="h-[600px] w-full" wire:ignore>
                <div class="tradingview-widget-container">
                    <div id="{{ $chartId }}" class="w-full h-full"></div>
                    <script src="https://s3.tradingview.com/tv.js"></script>
                    <script>
                        const isAdmin = @json($isAdmin);
                        const chartId = @json($chartId);

                        document.addEventListener('livewire:initialized', function () {
                            let widget = null;

                            const initWidget = () => {
                                if (widget) widget.remove();

                                widget = new TradingView.widget({
                                    width: "100%",
                                    height: "100%",
                                    theme:"light",
                                    symbol: "BINANCE:BTCUSDT",
                                    interval: "D",
                                    timezone: "Etc/UTC",
                                    style: "1",
                                    locale: "en",
                                    toolbar_bg: "#f1f3f6",
                                    enable_publishing: false,
                                    hide_side_toolbar: !isAdmin,
                                    allow_symbol_change: true,
                                    // hide_volume:!isAdmin,
                                    hide_volume:true,
                                    container_id: chartId
                                });
                            };

                            initWidget();

                            Livewire.on('refreshChart', initWidget);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
