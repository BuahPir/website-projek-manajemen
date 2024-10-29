<x-app-layout>
    <style>
        .welcome-text {
            font-size: 30px; /* 48px */
            line-height: 1;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div>
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="welcome-text font-semibold">Selamat Datang, {{Auth::user()->name}}!</h1>
                    <br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
