<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Deposit to Your Trading Account</h2>

                <form action="{{ route('bot.deposit.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="payment_type" class="block text-sm font-medium text-gray-700">Payment Type</label>
                        <select id="payment_type" name="payment_type" required
                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-[#011478] focus:outline-none focus:ring-[#011478] sm:text-sm">
                            <option value="" disabled selected>Select payment type</option>
                            <option value="card">Card</option>
                            <option value="crypto">Crypto</option>
                        </select>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Deposit Amount (USD)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="amount" type="number" name="amount" min="60" step="1" required
                                class="pl-3 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478] sm:text-sm" />
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Minimum deposit amount is $60</p>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#011478] hover:bg-[#011478]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#011478]">
                            Deposit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 