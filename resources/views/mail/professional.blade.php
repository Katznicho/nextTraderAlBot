<x-mail::message>
<img src="https://app.nextgentraderai.com/public/images/logo.png" alt="{{ config('app.name') }}" style="width: 150px; margin-bottom: 20px;">

# {{ $heading }}, {{ $user->name }}

{!! \Illuminate\Mail\Markdown::parse($body) !!}

Thanks for being with us,  
**The {{ config('app.name') }} Team**
</x-mail::message>
