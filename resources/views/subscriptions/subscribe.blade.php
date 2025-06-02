<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900">Subscribe to {{ $plan->name }}</h2>

                <div class="mt-4">
                    <p class="text-lg text-gray-700">
                        You are about to subscribe to the <span class="font-semibold">{{ $plan->name }}</span> plan.
                    </p>
                    <div class="mt-4">
                        <span class="text-3xl font-bold text-gray-900">
                            @if($plan->price)
                                ${{ number_format($plan->price, 2) }}
                            @else
                                Custom Pricing
                            @endif
                        </span>
                        <span class="text-base text-gray-500">/{{ $plan->billing_cycle }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <form action="{{ route('subscriptions.process', $plan->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Choose Payment Mode</label>
                            <div class="grid grid-cols-2 gap-4">

                                <!-- Card Option -->
                                <label class="block cursor-pointer">
                                    <input type="radio" name="payment_mode" value="card" class="peer hidden" required>
                                    <div class="peer-checked:border-[#011478] peer-checked:ring-2 peer-checked:ring-[#011478] border border-gray-300 rounded-lg p-6 text-center transition duration-200">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-8 h-8 text-gray-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v1.5H2.25v-1.5Zm0 3h19.5v9a2.25 2.25 0 0 1-2.25 2.25h-15A2.25 2.25 0 0 1 2.25 18v-8.25Z"/>
                                            </svg>
                                            <span class="text-lg font-medium text-gray-700">Card</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Crypto Option -->
                                <label class="block cursor-pointer">
                                    <input type="radio" name="payment_mode" value="crypto" class="peer hidden">
                                    <div class="peer-checked:border-[#011478] peer-checked:ring-2 peer-checked:ring-[#011478] border border-gray-300 rounded-lg p-6 text-center transition duration-200">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-8 h-8 text-gray-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M16.5 3a9 9 0 1 0 1.5 17.75M12 8v4.5l3 1.5"/>
                                            </svg>
                                            <span class="text-lg font-medium text-gray-700">Crypto</span>
                                        </div>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <button type="submit"
                            class="w-full mt-4 px-6 py-3 bg-[#011478] hover:bg-[#011478]/90 text-white font-semibold text-lg rounded-lg transition duration-200">
                            @if($plan->is_custom)
                                Contact Sales Team
                            @else
                                Proceed to Payment
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
