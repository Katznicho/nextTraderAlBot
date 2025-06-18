<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles        


    </head>
    <body
        class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"    
    >

        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>

        <!-- Page wrapper -->
        <div class="flex h-[100dvh] overflow-hidden">

            <x-app.sidebar :variant="$attributes['sidebarVariant']" />

            <!-- Content area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if($attributes['background']){{ $attributes['background'] }}@endif" x-ref="contentarea">

                <x-app.header :variant="$attributes['headerVariant']" />

                <main class="grow">
                    {{ $slot }}
                </main>

            </div>

        </div>

        @livewireScriptConfig
    </body>

    <div class="w-full bg-black text-white text-sm overflow-hidden fixed top-0 z-50">
 
</div>

</html>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6834530469270419089ef52e/1is668j3s';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->

<div class="w-full bg-[#0b0f1a] text-green-400 text-sm overflow-hidden fixed bottom-0 z-50">
  <marquee id="tickerMarquee" behavior="scroll" direction="left" scrollamount="4" class="py-1 px-4 font-mono">
    Loading market data...
  </marquee>
</div>

<script>
  function getRandomPrice(base, variance) {
    return (base + (Math.random() * variance * 2 - variance)).toFixed(2);
  }

  function generateTicker() {
    const btc = getRandomPrice(64120, 300);
    const eth = getRandomPrice(3145, 80);
    const nasdaq = getRandomPrice(13456, 120);
    const sp500 = getRandomPrice(4478, 50);
    const gold = getRandomPrice(1975, 20);
    const oil = getRandomPrice(82, 2);

    return `
      ▲ BTC/USD: $${btc} &nbsp;&nbsp; | 
      ▼ ETH/USD: $${eth} &nbsp;&nbsp; | 
      ▲ NASDAQ: ${nasdaq} &nbsp;&nbsp; | 
      ▼ S&P 500: ${sp500} &nbsp;&nbsp; |
      ▲ GOLD: $${gold} &nbsp;&nbsp; | 
      ▼ OIL: $${oil}
    `;
  }

  function updateTicker() {
    const marquee = document.getElementById('tickerMarquee');
    if (marquee) {
      marquee.innerHTML = generateTicker();
    }
  }

  // Initial run
  updateTicker();

  // Update every 10 seconds
  setInterval(updateTicker, 10000);
</script>


