<x-app-layout>
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100 pt-3">
                    <h1 class="text-[32px] font-extrabold" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">Selamat Datang, {{Auth::user()->name}}! </h1>

                    <br>
                </div>
            </div>
        </div>
        <div class="relative">
            <!-- Notification Icon -->
            <x-primary-button id="notificationButton" class="relative focus:outline-none border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" class="mr-1" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                  </svg>
                {{__("Notification")}}
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-red-600 rounded-full ring-2 ring-white"></span>
                @endif
            </x-primary-button>

            <!-- Notification Dropdown -->
            <div id="notificationDropdown" class="hidden absolute mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                <!-- Header -->
                <div class="p-4 bg-gray-100 border-b border-gray-200 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-700">Notifications</h3>
                </div>
                <!-- Notifications List -->
                <ul class="divide-y divide-gray-200 max-h-48 overflow-y-auto">
                    @forelse(auth()->user()->notifications as $notification)
                        <li class="p-4 hover:bg-gray-50">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $notification->data['activity_name'] }}</p>
                            <p class="text-xs text-gray-500 mt-1 truncate">{{ $notification->data['description'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </li>
                    @empty
                        <li class="p-4 text-center text-gray-500">No notifications found.</li>
                    @endforelse
                </ul>
                <!-- Footer -->
                <div class="p-4 text-center bg-gray-100 rounded-b-lg border-t border-gray-200">
                    <a href="{{ route('notifications.markAllAsRead') }}" class="text-sm text-indigo-600 font-medium hover:underline">Mark all as read</a>
                </div>
            </div>
        </div>


        <script>
            document.getElementById('notificationButton').addEventListener('click', function () {
                const dropdown = document.getElementById('notificationDropdown');
                const isHidden = dropdown.classList.contains('hidden');

                // Hide dropdown if it's already open
                if (!isHidden) {
                    dropdown.classList.add('hidden');
                } else {
                    dropdown.classList.remove('hidden');
                }
            });
        </script>

</x-app-layout>
