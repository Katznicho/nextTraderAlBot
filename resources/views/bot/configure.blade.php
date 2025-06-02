<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Configure Your Trading Bot</h2>

                <form action="{{ route('bot.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Trading Platform</label>
                            <select name="platform" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                                <option value="mt4">MetaTrader 4</option>
                                <option value="mt5">MetaTrader 5</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Account ID</label>
                            <input type="text" name="account_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Server</label>
                            <input type="text" name="server" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Login</label>
                            <input type="text" name="login" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#011478] hover:bg-[#011478]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#011478]">
                            Save Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>