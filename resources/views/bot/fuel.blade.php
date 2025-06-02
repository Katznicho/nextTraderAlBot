<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Fuel Your Trading Bot</h2>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Current Fuel Balance</h3>
                            <p class="text-3xl font-bold text-[#011478] mt-2">${{ number_format($botConfig->fuel_balance, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Last Fueled</p>
                            <p class="text-sm font-medium text-gray-900">{{ $botConfig->last_fueled_at ? \Carbon\Carbon::parse($botConfig->last_fueled_at)->diffForHumans() : 'Never' }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('bot.fuel.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fuel Amount ($)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" min="10" step="10" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]" required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Minimum fuel amount is $10</p>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#011478] hover:bg-[#011478]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#011478]">
                            Add Fuel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>