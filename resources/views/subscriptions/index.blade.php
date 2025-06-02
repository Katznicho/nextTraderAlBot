<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($needsSubscription)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                You currently don't have an active subscription. Please select a plan below to access all features.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h2>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-gray-900">
                                @if($plan->price)
                                    ${{ number_format($plan->price, 2) }}
                                @else
                                    Custom
                                @endif
                            </span>
                            <span class="text-base font-medium text-gray-500">/{{ $plan->billing_cycle }}</span>
                        </div>

                        <ul class="mt-6 space-y-4">
                            @foreach(json_decode($plan->features) as $feature => $value)
                                <li class="flex space-x-3">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-base text-gray-700">
                                        {{ ucwords(str_replace('_', ' ', $feature)) }}:
                                        @if(is_bool($value))
                                            {{ $value ? 'Yes' : 'No' }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-8">
                            <a href="{{ route('subscriptions.subscribe', $plan->id) }}" 
                               class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#011478] hover:bg-[#011478]/90">
                                @if($plan->is_custom)
                                    Contact Sales
                                @else
                                    Subscribe Now
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>