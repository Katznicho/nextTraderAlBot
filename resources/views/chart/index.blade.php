@php
    $isAdmin = auth()->user()->user_type === 'Admin';
    $chartId = 'tradingview_chart_container';
@endphp

<x-app-layout>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-7xl mx-auto pt-1 px-4">
        <!-- Trading Performance Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">

            <!-- Buy/Sell with Lot Size Section -->
            <div x-data="{
                isAdmin: @json($isAdmin),
                lotSize: 0.5,

                increase() {
                    this.lotSize = (parseFloat(this.lotSize) + 0.1).toFixed(2);
                },
                decrease() {
                    if (this.lotSize > 0.1) {
                        this.lotSize = (parseFloat(this.lotSize) - 0.1).toFixed(2);
                    }
                },
                handleAction() {
                    if (!this.isAdmin) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Activation Required',
                            text: 'Please activate your AI robot to perform trades.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#011478'
                        });
                    }
                }
            }"
            class="flex flex-row flex-wrap justify-between items-center gap-2 sm:gap-4 mb-6 text-xs font-medium w-full">

                <!-- BUY Button -->
                <div class="flex-1 min-w-[100px] max-w-[140px] flex justify-center">
                    <button @click="handleAction"
                        class="border border-blue-500 text-blue-500 hover:bg-blue-50 rounded px-3 py-3 w-full text-center transition leading-tight">
                        <p class="uppercase text-sm tracking-wide">Buy</p>
                    </button>
                </div>

                <!-- LOT SIZE -->
                <div class="flex-1 min-w-[80px] max-w-[120px] flex justify-center">
                    <div class="border border-gray-300 text-gray-700 rounded px-3 py-3 flex items-center space-x-3 w-full justify-center">
                        <button @click="decrease" class="text-base font-semibold text-gray-500 hover:text-black transition">&#x25BC;</button>
                        <span class="text-base font-medium" x-text="lotSize"></span>
                        <button @click="increase" class="text-base font-semibold text-gray-500 hover:text-black transition">&#x25B2;</button>
                    </div>
                </div>

                <!-- SELL Button -->
                <div class="flex-1 min-w-[100px] max-w-[140px] flex justify-center">
                    <button @click="handleAction"
                        class="border border-red-500 text-red-500 hover:bg-red-50 rounded px-3 py-3 w-full text-center transition leading-tight">
                        <p class="uppercase text-sm tracking-wide">Sell</p>
                    </button>
                </div>
            </div>
            <!-- End Buy/Sell with Lot Size Section -->

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
