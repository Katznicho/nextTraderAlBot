<x-mail::message>
# Withdrawal Request Received

Hello {{ $user->name }},

We have received your withdrawal request and it's currently being processed. Below are the details:

<x-mail::panel>
**Amount (USD):** ${{ number_format($withdrawal->amount_usd, 2) }}  
**Cryptocurrency:** {{ $withdrawal->crypto_currency }}  
**Converted Amount:** {{ number_format($withdrawal->converted_amount, 8) }} {{ $withdrawal->crypto_currency }}  
**Wallet Address:** {{ $withdrawal->crypto_address }}  
**Status:** {{ ucfirst($withdrawal->status) }}
</x-mail::panel>

Please note that processing times may vary depending on blockchain network conditions.

We’ll notify you once your withdrawal has been completed.

---

> Need help? Our support team is ready to assist you at any time.

Thanks for choosing **{{ config('app.name') }}**.  
We’re committed to helping you succeed in your financial journey!

Warm regards,  
**The {{ config('app.name') }} Team**
</x-mail::message>
<x-slot:footer>
    <p class="text-xs text-gray-500">
        This is an automated message. Please do not reply directly to this email.
    </p>
</x-slot:footer>