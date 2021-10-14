@props(['type' => null, 'header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        @if ($type === 'guest')
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <div>
                    <a href="/">
                        <x-utils.logo class="h-20" />
                    </a>
                </div>

                <x-utils.frame size="md" class="mt-6">
                    {{ $slot }}
                </x-utils.frame>
            </div>
        @else
            <div class="min-h-screen bg-gray-100">
                <x-layouts.navigation />

                <!-- Page Heading -->
                @if ($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $header }}
                            </h2>
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                            <!-- Session Status -->
                            <x-utils.forms.session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-utils.forms.validation-errors class="mb-4" :errors="$errors" />

                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        @endif
    </body>
</html>
