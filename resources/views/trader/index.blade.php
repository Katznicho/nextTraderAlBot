<x-app-layout>

    @php
        $isAdmin = auth()->user()->user_type === 'Admin';
    @endphp

    <div class="max-w-7xl mx-auto py-10 px-6">
        @if ($isAdmin)
            {{-- Page Title --}}
            <h2 class="text-2xl font-bold text-gray-100 mb-4">Your Current Trades</h2>

            {{-- Total Profit Card --}}
            <div id="totalProfitBar" class="text-white text-center rounded-lg text-2xl font-semibold py-4 mb-6 shadow" style="background-color: #031369;">
                0.00 USD
            </div>

            {{-- Trades Table --}}
            <div class="overflow-x-auto rounded-xl bg-gray-800 shadow p-4">
                <table class="min-w-full text-sm table-auto border border-gray-700">
                    <thead class="uppercase text-xs font-semibold text-gray-400 border-b border-gray-600">
                        <tr>
                            <th class="py-3 px-4 text-left">Pair</th>
                            <th class="py-3 px-4 text-left">Lot Size</th>
                            <th class="py-3 px-4 text-right">Profit</th>
                        </tr>
                    </thead>
                    <tbody id="tradesTable" class="text-white divide-y divide-gray-700">
                        <!-- JavaScript will populate this -->
                    </tbody>
                </table>
            </div>

            {{-- JavaScript --}}
            <script>
                const tradeCount = 10;

                function getRandomProfit() {
                    return (Math.random() * (170 - 110) + 110).toFixed(2);
                }

                function generateTrades() {
                    const trades = [];
                    for (let i = 0; i < tradeCount; i++) {
                        trades.push({
                            pair: 'XAUUSD',
                            side: 'buy',
                            lotSize: 0.05,
                            profit: getRandomProfit()
                        });
                    }
                    return trades;
                }

                function renderTrades(trades) {
                    const table = document.getElementById('tradesTable');
                    table.innerHTML = '';
                    let totalProfit = 0;

                    trades.forEach(trade => {
                        totalProfit += parseFloat(trade.profit);

                        const row = document.createElement('tr');
                        row.classList.add('hover:bg-gray-700', 'transition');

                        row.innerHTML = `
                            <td class="py-3 px-4">
                                <span class="font-medium text-white">${trade.pair}</span>
                                <span class="ml-1 font-medium text-green-400">${trade.side}</span>
                            </td>
                            <td class="py-3 px-4">${trade.lotSize.toFixed(2)}</td>
                            <td class="py-3 px-4 text-right">$${parseFloat(trade.profit).toFixed(2)}</td>
                        `;
                        table.appendChild(row);
                    });

                    document.getElementById('totalProfitBar').innerText = `${totalProfit.toFixed(2)} USD`;
                }

                function updateTrades() {
                    const trades = generateTrades();
                    renderTrades(trades);
                }

                document.addEventListener('DOMContentLoaded', () => {
                    updateTrades();
                    setInterval(updateTrades, 2000); // Update every 2 seconds
                });
            </script>
        @else
            <h2 class="text-xl font-semibold text-gray-100">No current trades</h2>
        @endif
    </div>
</x-app-layout>
