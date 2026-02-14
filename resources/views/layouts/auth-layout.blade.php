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
    <title>{{ $title ?? 'Auth' }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="overflow-x-hidden bg-slate-900 text-slate-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        @yield('content')
    </div>

    {{-- Komponen Global Toast Notification --}}
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
            <div
                class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg 
        {{ $toastType === 'success' ? 'text-emerald-400 bg-emerald-500/20' : '' }}
        {{ $toastType === 'error' ? 'text-red-400 bg-red-500/20' : '' }}
        {{ $toastType === 'warning' ? 'text-amber-400 bg-amber-500/20' : '' }}">

                @if ($toastType === 'success')
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 11.917 9.724 16.5 19 7.5" />
                    </svg>
                @elseif($toastType === 'error')
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                @elseif($toastType === 'warning')
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                @endif
            </div>

            {{-- Message --}}
            <div class="ms-3 text-sm font-medium">{{ $toastMessage }}</div>

            {{-- Close Button --}}
            <button type="button" @click="show = false"
                class="ms-auto flex items-center justify-center text-slate-400 hover:text-white bg-transparent hover:bg-slate-700 rounded-lg text-sm p-1.5 focus:outline-none transition-colors"
                aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </button>
        </div>
    @endif
</body>

</html>
