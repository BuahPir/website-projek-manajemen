<x-app-layout>
    <div>
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100 pt-3">
                    <h1 class="text-[32px] font-extrabold" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">Selamat Datang, {{Auth::user()->name}}!</h1>
                    <br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
