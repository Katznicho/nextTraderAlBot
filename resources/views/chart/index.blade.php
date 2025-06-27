@php
    $isAdmin = auth()->user()->user_type === 'Admin';
    $chartId = 'tradingview_chart_container';
@endphp

<x-app-layout>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-7xl mx-auto py-1 px-1">
        <!-- Trading Performance Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm ">

            <!-- Buy/Sell with Lot Size Section -->
            <!-- Buy/Sell with Lot Size Section -->
            <div x-data="{
                isAdmin: @json($isAdmin),
                lotSize: 0.5,
                buyPrice: 2799.00,
                sellPrice: 2798.84,
            
                increase() {
                    this.lotSize = (parseFloat(this.lotSize) + 0.1).toFixed(2);
                },
                decrease() {
                    if (this.lotSize > 0.1) {
                        this.lotSize = (parseFloat(this.lotSize) - 0.1).toFixed(2);
                    }
                },
                changePrices() {
                    this.buyPrice = (2799 + Math.random()).toFixed(2);
                    this.sellPrice = (2798 + Math.random()).toFixed(2);
                },
                handleAction() {
                    this.changePrices();
                    if (!this.isAdmin) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Activation Required',
                            text: 'Please activate your AI robot to perform trades.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#011478'
                        });
                    }
                },
                init() {
                    setInterval(() => this.changePrices(), 10000);
                }
            }" x-init="init()"
                class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 text-white text-sm font-semibold">
                <!-- SELL -->
                <div class="flex-1 flex justify-center">
                    <button @click="handleAction"
                        class="bg-red-600 rounded-md px-6 py-3 shadow w-full max-w-xs text-center">
                        <p class="text-xs uppercase text-white tracking-wide">Sell</p>
                        <div class="text-2xl font-bold leading-tight">
                            <span x-text="sellPrice"></span><sup class="text-xs align-super">9</sup>
                        </div>
                    </button>
                </div>

                <!-- LOT SIZE -->
                <div class="flex-1 flex justify-center">
                    <div
                        class="bg-white text-gray-800 rounded-md px-3 py-2 shadow flex items-center space-x-6 w-full max-w-xs justify-center">
                        <button @click="decrease"
                            class="text-xl font-bold text-gray-600 hover:text-black transition">&#x25BC;</button>
                        <span class="text-2xl font-semibold" x-text="lotSize"></span>
                        <button @click="increase"
                            class="text-xl font-bold text-gray-600 hover:text-black transition">&#x25B2;</button>
                    </div>
                </div>

                <!-- BUY -->
                <div class="flex-1 flex justify-center">
                    <button @click="handleAction"
                        class="bg-red-600 rounded-md px-2 py-2 shadow w-full max-w-xs text-center">
                        <p class="text-xs uppercase text-white tracking-wide">Buy</p>
                        <div class="text-2xl font-bold leading-tight">
                            <span x-text="buyPrice"></span><sup class="text-xs align-super">9</sup>
                        </div>
                    </button>
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

                        document.addEventListener('livewire:initialized', function() {
                            let widget = null;

                            const initWidget = () => {
                                if (widget) widget.remove();

                                widget = new TradingView.widget({
                                    width: "100%",
                                    height: "100%",
                                    theme: "light",
                                    symbol: "BINANCE:BTCUSDT",
                                    interval: "D",
                                    timezone: "Etc/UTC",
                                    style: "1",
                                    locale: "en",
                                    toolbar_bg: "#f1f3f6",
                                    enable_publishing: false,
                                    hide_side_toolbar: !isAdmin,
                                    allow_symbol_change: true,
                                    hide_volume: true,
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
