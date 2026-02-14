<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="overflow-x-hidden bg-slate-900 text-slate-100 font-sans antialiased">
    <div x-data="{ sidebarExpanded: false }" class="flex h-screen w-full">
        <div class="relative z-50 h-full shrink-0 transition-all duration-300 border-e border-slate-700 bg-slate-800"
            :class="sidebarExpanded ? 'w-64' : 'w-20'">
            @include('components.sidebar-navbar')
        </div>
        <div class="flex-1 w-full h-full overflow-y-auto overflow-x-hidden bg-slate-900 transition-all duration-300">
            <div class="h-full bg-slate-900 p-12">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Chart.js Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div x-data="{ 
            showConfirm: false, 
            title: '', 
            message: '', 
            actionUrl: '', 
            method: 'POST', 
            btnText: 'Konfirmasi', 
            btnColor: 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' 
        }"
        @open-confirm.window="
            title = $event.detail.title;
            message = $event.detail.message;
            actionUrl = $event.detail.actionUrl;
            method = $event.detail.method || 'POST';
            btnText = $event.detail.btnText || 'Konfirmasi';
            btnColor = $event.detail.btnColor || 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500';
            showConfirm = true;
        ">
        
        <div x-show="showConfirm" style="display: none;" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
             
            <div x-show="showConfirm"
                 @click.away="showConfirm = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-md bg-slate-800 rounded-2xl shadow-2xl border border-slate-700 overflow-hidden">
                
                <div class="p-6 sm:p-8 text-center">
                    <div class="mx-auto flex items-center justify-center size-14 rounded-full mb-4"
                         :class="btnColor.includes('red') ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400'">
                        <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-slate-100 mb-2" x-text="title"></h3>
                    <p class="text-sm text-slate-400" x-text="message"></p>

                    <form :action="actionUrl" method="POST" class="mt-8 flex flex-col-reverse sm:flex-row gap-3 justify-center">
                        @csrf
                        <template x-if="method !== 'POST' && method !== 'GET'">
                            <input type="hidden" name="_method" :value="method">
                        </template>

                        <button type="button" @click="showConfirm = false" class="w-full cursor-pointer sm:w-auto px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-white cursor-pointer rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800"
                                :class="btnColor" x-text="btnText">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @php
        $toastType = '';
        $toastMessage = '';

        if (session('success')) {
            $toastType = 'success';
            $toastMessage = session('success');
        } elseif (session('error') || session('danger')) {
            $toastType = 'error';
            $toastMessage = session('error') ?? session('danger');
        } elseif (session('warning')) {
            $toastType = 'warning';
            $toastMessage = session('warning');
        }
    @endphp

    @if ($toastType)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed top-6 right-6 z-[100] flex items-center w-full max-w-sm p-4 bg-slate-800 rounded-xl shadow-2xl border border-slate-700 text-slate-200"
            role="alert">

            {{-- Dynamic Icon & Background --}}
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg 
                {{ $toastType === 'success' ? 'text-emerald-400 bg-emerald-500/20' : '' }}
                {{ $toastType === 'error' ? 'text-red-400 bg-red-500/20' : '' }}
                {{ $toastType === 'warning' ? 'text-amber-400 bg-amber-500/20' : '' }}">

                @if ($toastType === 'success')
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" /></svg>
                @elseif($toastType === 'error')
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" /></svg>
                @elseif($toastType === 'warning')
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                @endif
            </div>

            {{-- Message --}}
            <div class="ms-3 text-sm font-medium">{{ $toastMessage }}</div>

            {{-- Close Button --}}
            <button type="button" @click="show = false"
                class="ms-auto flex items-center justify-center text-slate-400 hover:text-white bg-transparent hover:bg-slate-700 rounded-lg text-sm p-1.5 focus:outline-none transition-colors"
                aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" /></svg>
            </button>
        </div>
    @endif
</body>
</html>