<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your Trading History</h2>

        <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="py-2 px-4">Exchange</th>
                        <th class="py-2 px-4">Symbol</th>
                        <th class="py-2 px-4">Side</th>
                        <th class="py-2 px-4">Quantity</th>
                        <th class="py-2 px-4">Price</th>
                        <th class="py-2 px-4">Total</th>
                        <th class="py-2 px-4">Profit</th>
                        <th class="py-2 px-4">Fees</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Executed At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($trades as $trade)
                        <tr>
                            <td class="py-2 px-4">{{ $trade->exchange }}</td>
                            <td class="py-2 px-4">{{ $trade->symbol }}</td>
                            <td class="py-2 px-4 text-xs font-bold text-{{ $trade->side === 'buy' ? 'green-600' : 'red-600' }}">
                                {{ ucfirst($trade->side) }}
                            </td>
                            <td class="py-2 px-4">{{ $trade->quantity }}</td>
                            <td class="py-2 px-4">${{ number_format($trade->price, 2) }}</td>
                            <td class="py-2 px-4">${{ number_format($trade->total, 2) }}</td>
                            <td class="py-2 px-4">
                                <span class="{{ $trade->profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format($trade->profit, 2) }}
                                </span>
                            </td>
                            <td class="py-2 px-4">${{ number_format($trade->fees, 2) }}</td>
                            <td class="py-2 px-4">
                                <span class="text-xs px-2 py-1 rounded-full font-medium 
                                    {{ $trade->status === 'executed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($trade->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($trade->executed_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-gray-500">No trading history available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
