<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Support Center</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Get help with your trading bot and account management</p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-[#011478]/10 rounded-full">
                        <svg class="h-6 w-6 text-[#011478]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Live Chat</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Chat with our support team</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-[#011478]/10 rounded-full">
                        <svg class="h-6 w-6 text-[#011478]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Submit Ticket</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Create a support ticket</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-[#011478]/10 rounded-full">
                        <svg class="h-6 w-6 text-[#011478]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Knowledge Base</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Browse help articles</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Tickets -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Your Support Tickets</h3>
                <button class="inline-flex items-center px-4 py-2 bg-[#011478] rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#011478]/90 focus:outline-none focus:border-[#011478]/90 focus:ring focus:ring-[#011478]/50 active:bg-[#011478]/90 disabled:opacity-25 transition">
                    New Ticket
                </button>
            </div>

            <!-- Ticket List Component -->
            {{-- <livewire:list-support-tickets /> --}}
        </div>

        <!-- FAQ Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Frequently Asked Questions</h3>
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <button @click="open = !open" class="flex items-center justify-between w-full">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">How does the automated trading bot work?</span>
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Our trading bot uses advanced algorithms to analyze market trends, execute trades automatically based on predefined strategies, and manage risk according to your settings. It operates 24/7 to identify and capitalize on trading opportunities.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <button @click="open = !open" class="flex items-center justify-between w-full">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">What subscription plans are available?</span>
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">We offer multiple subscription tiers: Basic, Pro, and Enterprise. Each plan includes different features, trading limits, and support levels. Visit our subscription page for detailed information about each plan's benefits.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <button @click="open = !open" class="flex items-center justify-between w-full">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">How can I customize my trading strategies?</span>
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Access the Bot Configuration section to customize your trading parameters, including risk levels, trading pairs, and strategy preferences. You can also set up custom indicators and automated rules based on market conditions.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <button @click="open = !open" class="flex items-center justify-between w-full">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">What security measures are in place?</span>
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">We implement industry-standard security protocols including 2FA, encryption for all sensitive data, regular security audits, and secure API connections. Your funds and trading activities are protected by multiple layers of security.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <button @click="open = !open" class="flex items-center justify-between w-full">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">How do I track my trading performance?</span>
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Visit the Trading History section to view detailed performance metrics, including profit/loss statistics, trade history, and analytics. You can generate custom reports and export data for further analysis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<div class="space-y-4">
    <!-- Live Chat Button -->
    <button
        onclick="loadTawkTo()"
        class="inline-flex items-center px-4 py-2 bg-[#011478] text-white rounded-lg hover:bg-[#011478]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#011478]">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        Start Live Chat
    </button>

    <!-- Tawk.to Integration -->
    <script type="text/javascript">
        function loadTawkTo() {
            var s1 = document.createElement("script");
            var s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/YOUR_WIDGET_CODE/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
            
            // Remove the click event after loading
            document.querySelector('button').onclick = null;
        }
    </script>
</div>
