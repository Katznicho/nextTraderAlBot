<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Users List</h2>
                <div class="mb-4">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full dark:bg-blue-900 dark:text-blue-200">
                        Total Users: {{ $users->count() }}
                    </span>
                </div>

                <table class="w-full table-auto text-left">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                            <th class="p-2">Name</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Balance</th>
                            <th class="p-2">Profit</th>
                            <th class="p-2">Total Trades</th>
                            <th class="p-2">Join Date</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-2">{{ $user->name }}</td>
                                <td class="p-2">{{ $user->email }}</td>
                                <td class="p-2">{{ $user->balance }}</td>
                                <td class="p-2">{{ $user->profit }}</td>
                                <td class="p-2">{{ $user->total_trades }}</td>
                                <td class="p-2">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="p-2 space-x-2">
                                    <button
                                        onclick="openModal({{ $user }})"
                                        class="bg-blue-600 hover:bg-blue-800 text-white px-3 py-1 rounded inline-flex items-center"
                                        title="Edit"
                                    >
                                        <!-- Heroicon: Pencil -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h2v2H7v-2z" />
                                        </svg>
                                    </button>
                                    @if(auth()->user()->id !== $user->id)
                                        <a href="{{ route('impersonate', $user->id) }}"
                                           class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded inline-flex items-center"
                                           title="Impersonate"
                                        >
                                            <!-- Heroicon: User Switch (use User icon as example) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form action="{{ route('user-subscriptions.store') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="subscription_id" value="1">
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-800 text-white px-3 py-1 rounded inline-flex items-center"
                                            title="Create User Subscription"
                                        >
                                            <!-- Heroicon: Plus -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </form>
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
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit User</h2>
            <form id="editUserForm" method="POST" action="{{ route('users.update', ['user' => '__ID__']) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="userId">
                <div class="mb-4">
                    <label for="balance" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Balance</label>
                    <input type="number" step="0.01" name="balance" id="balance" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="mb-4">
                    <label for="profit" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Profit</label>
                    <input type="number" step="0.01" name="profit" id="profit" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="mb-4">
                    <label for="total_trades" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Total Trades</label>
                    <input type="number" name="total_trades" id="total_trades" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(user) {
            document.getElementById('userId').value = user.id;
            document.getElementById('balance').value = user.balance;
            document.getElementById('profit').value = user.profit;
            document.getElementById('total_trades').value = user.total_trades;

            let form = document.getElementById('editUserForm');
            form.action = form.action.replace('__ID__', user.id);

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('flex');
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
