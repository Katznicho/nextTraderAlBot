<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Connected Bots</h2>

                <table class="w-full table-auto text-left text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                            <th class="p-2">Platform</th>
                            <th class="p-2">Account ID</th>
                            <th class="p-2">Server</th>
                            <th class="p-2">Login</th>
                            <th class="p-2">Fuel Balance</th>
                            <th class="p-2">Last Fueled</th>
                            <th class="p-2">Connection Status</th>
                            <th class="p-2">Strategy</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Image</th>
                            <th class="p-2">User</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bots as $bot)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-2">{{ $bot->platform }}</td>
                                <td class="p-2">{{ $bot->account_id }}</td>
                                <td class="p-2">{{ $bot->server }}</td>
                                <td class="p-2">{{ $bot->login }}</td>
                                <td class="p-2">{{ $bot->fuel_balance }}</td>
                                <td class="p-2">{{ $bot->last_fueled_at?->format('Y-m-d H:i') ?? 'N/A' }}</td>
                                <td class="p-2">{{ $bot->connection_status }}</td>
                                <td class="p-2">{{ $bot->current_strategy }}</td>
                                <td class="p-2 capitalize">{{ $bot->status_message ?? 'N/A' }}</td>
                                <td class="p-2 max-w-xs truncate text-xs">{{ $bot->image_url }}</td>
                                <td class="p-2">{{ $bot->user->name }}</td>
                                <td class="p-2">
                                    <button onclick="openModal({{ $bot }})"
                                        class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-1 rounded">
                                        Edit
                                    </button>

                                    @if ($bot->connection_status === 'connected')
                                        <button onclick="openCreditModal({{ $bot }})"
                                            class="bg-green-600 hover:bg-green-800 text-white px-4 py-1 rounded mt-2">
                                            Add Credits
                                        </button>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="editModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Bot</h2>
            <form id="editBotForm" method="POST" action="{{ route('bots.update', ['bot' => '__ID__']) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="botId">

                <div class="mb-4">
                    <label for="status_message"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                    <select name="status_message" id="status_message"
                        class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white" required>
                        <option value="connecting">Connecting</option>
                        <option value="connected">Connected</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Image
                        URL</label>
                    <input type="text" name="image_url" id="image_url"
                        class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Credits Modal -->
<div id="creditModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Add Bot Credits</h2>
        <form id="addCreditForm" method="POST" action="{{ route('bots.addCredits', ['bot' => '__ID__']) }}">
            @csrf
            <input type="hidden" name="id" id="creditBotId">
            <div class="mb-4">
                <label for="fuel_balance" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Credits to Add</label>
                <input type="number" step="0.01" name="fuel_balance" id="fuel_balance" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white" required>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeCreditModal()" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Add</button>
            </div>
        </form>
    </div>
</div>


    <script>
        function openModal(bot) {
            document.getElementById('botId').value = bot.id;
            document.getElementById('image_url').value = bot.image_url ?? '';

            const select = document.getElementById('status_message');
            select.value = bot.status_message ?? 'connecting';

            let form = document.getElementById('editBotForm');
            form.action = form.action.replace('__ID__', bot.id);

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('flex');
            document.getElementById('editModal').classList.add('hidden');
        }


        function openCreditModal(bot) {
    document.getElementById('creditBotId').value = bot.id;
    document.getElementById('fuel_balance').value = '';

    let form = document.getElementById('addCreditForm');
    form.action = form.action.replace('__ID__', bot.id);

    document.getElementById('creditModal').classList.remove('hidden');
    document.getElementById('creditModal').classList.add('flex');
}

function closeCreditModal() {
    document.getElementById('creditModal').classList.remove('flex');
    document.getElementById('creditModal').classList.add('hidden');
}

    </script>
</x-app-layout>
