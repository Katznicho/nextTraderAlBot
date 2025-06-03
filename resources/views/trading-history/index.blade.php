<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your Trading History</h2>

        <div class="overflow-x-auto bg-white rounded-xl shadow p-4">
            <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="py-3 px-4 text-left">Pair</th>
                        <th class="py-3 px-4 text-left">Lot Size</th>
                        <th class="py-3 px-4 text-left">Profit</th>
                        <th class="py-3 px-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($trades as $trade)
                        <tr>
                            <td class="py-3 px-4">
                                <span class="font-medium text-gray-800">{{ $trade->symbol }}</span>
                                <span class="ml-1 font-medium {{ $trade->side === 'buy' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ strtolower($trade->side) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ number_format($trade->lot_size, 2) }}</td>
                            <td class="py-3 px-4">
                                ${{ number_format($trade->profit, 2) }}
                            </td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($trade->executed_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">No trading history available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
