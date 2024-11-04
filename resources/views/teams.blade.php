<x-app-layout>
    <style>
        .avatar-group div {
            position: relative;
            z-index: 1;
            margin-left: -10px; /* Adjust this for tighter or looser overlap */
        }
    </style>

    <header class="py-5 text-4xl font-extrabold" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
        {{__('Teams')}}
    </header>
    <x-nav-link :href="route('create_teams')" :active="request()->routeIs('create_teams')" class="inline-flex py-2">
        <x-button>
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
            </svg>
            <span style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">{{__('Create Teams')}}</span>
        </x-button>
    </x-nav-link>
    <br>
    <div class="flex items-center rounded-md bg-slate-200">
        <div class="container mx-auto py-5">
            <!-- Heading -->
            <h2 class="text-2xl font-semibold mb-4 px-4 ">List of Teams: </h2>

            <!-- List of Teams -->
            @foreach ($allTeams as $team)
                <div class="mb-3 px-4">
                    <!-- Team Name and Avatars -->
                    <div class="flex items-center space-x-3">
                        <!-- Team Icon and Name -->
                        <div class="flex items-center space-x-2 border-b border-gray-300 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                            </svg>
                            <span class="font-semibold text-gray-700">{{ $team->name }}</span>
                        </div>
                    </div>

                    <!-- Avatar and Names List -->
                    <div class="flex items-center flex-wrap space-x-4 mt-3">
                        @foreach ($team->users as $user)
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-white">
                                <img src="{{ $user->picture ? asset('pictures/' . $user->picture) : asset('img/person-fill.svg') }}" alt="{{ $user->name }}" class="w-8 h-8 object-cover">
                            </div>
                            <span class="text-sm text-gray-600">{{ $user->name }}</span>
                        </div>
                        @endforeach
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this team?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 translate-y-1 translate-x-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
