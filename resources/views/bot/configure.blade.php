<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-[#0f172a] to-[#1e293b] min-h-screen" x-data="{
        step: 1,
        brokerType: '',
        purchaseCode: '',
        licenseKey: '',
        activationNumber: '',
        validateKeys() {
            return this.purchaseCode === 'PC-XYZ123-456789-ABCD' &&
                   this.licenseKey === 'LK-987654-ZYXW-3210-AB12-CD34' &&
                   this.activationNumber === 'AN-54321-WXYZ-0987-6543';
        }
    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur-md shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Configure Your Trading Bot</h2>

                <form action="{{ route('bot.store') }}" method="POST" class="space-y-6"
                    @submit.prevent="
                        let inputs = $el.querySelectorAll('input[required], select[required]');
                        for (let input of inputs) {
                            if (!input.value.trim()) {
                                alert('Please fill all required fields before submitting.');
                                input.focus();
                                return;
                            }
                        }
                        $el.submit();
                    ">
                    @csrf

                    {{-- Step 1 --}}
                    <div x-show="step === 1" x-cloak>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Select Broker Type <span class="text-red-600">*</span>
                        </label>
                        <div class="flex space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="broker_type" value="mt" x-model="brokerType"
                                    class="text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                <span class="ml-2 text-gray-900">MT4 / MT5</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="broker_type" value="in_app" x-model="brokerType"
                                    class="text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                <span class="ml-2 text-gray-900">In-App Trading</span>
                            </label>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="
                                if (brokerType !== '') {
                                    step = 2;
                                } else {
                                    alert('Please select a broker type before continuing.');
                                }
                            "
                                class="bg-[#011478] text-white px-4 py-2 rounded-md hover:bg-[#011478]/90">
                                Next
                            </button>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div x-show="step === 2" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Purchase Code <span class="text-red-600">*</span></label>
                                <input type="text" name="purchase_code" required x-model="purchaseCode"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">License Key <span class="text-red-600">*</span></label>
                                <input type="text" name="license_key" required x-model="licenseKey"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Activation Number <span class="text-red-600">*</span></label>
                                <input type="text" name="activation_number" required x-model="activationNumber"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <button type="button" @click="step = 1"
                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                                Back
                            </button>
                            <button type="button" @click="
                                if (purchaseCode.trim() !== '' && licenseKey.trim() !== '' && activationNumber.trim() !== '') {
                                    if (validateKeys()) {
                                        step = 3;
                                    } else {
                                        alert('Invalid license details. Please check your keys.');
                                    }
                                } else {
                                    alert('Please fill in all license and activation fields.');
                                }
                            "
                                class="bg-[#011478] text-white px-4 py-2 rounded-md hover:bg-[#011478]/90">
                                Next
                            </button>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div x-show="step === 3" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Broker <span class="text-red-600">*</span></label>
                                <input type="text" name="account_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Metatrader Version <span class="text-red-600">*</span></label>
                                <select name="platform" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                                    <option value="">-- Select Version --</option>
                                    <option value="mt4">MetaTrader 4</option>
                                    <option value="mt5">MetaTrader 5</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Broker Server <span class="text-red-600">*</span></label>
                                <input type="text" name="server" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Broker Login <span class="text-red-600">*</span></label>
                                <input type="text" name="login" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Broker Password <span class="text-red-600">*</span></label>
                                <input type="password" name="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#011478] focus:ring-[#011478]">
                            </div>
                        </div>

                        <div class="flex justify-between mt-6">
                            <button type="button" @click="step = 2"
                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                                Back
                            </button>
                            <button type="submit"
                                class="bg-[#011478] text-white px-4 py-2 rounded-md hover:bg-[#011478]/90">
                                Finish & Connect
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mt-6 text-sm text-gray-600 italic">
                    It takes 2-5 hours to fully connect your bot after submitting all details.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
