<div>
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
            <div class="flex h-16 shrink-0 items-center space-x-2">
                <a href="{{route ('dashboard')}}" class="flex items-center space-x-2">
                    <x-application-logo class="w-10 h-auto"/>
                    <span class="text-lg font-semibold text-gray-800">ProSync</span>
                </a>
            </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                <li>
                    <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        <svg class="h-6 w-6 shrink-0 group-hover:text-indigo-600 {{ Request::is('dashboard') ? 'text-indigo-600' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('teams')" :active="request()->routeIs('teams')" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        <svg class="h-6 w-6 shrink-0 group-hover:text-indigo-600 {{ Request::is('teams') ? 'text-indigo-600' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        {{ __('Team') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('projects')" :active="request()->routeIs('projects')" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                    <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-indigo-600 {{ Request::is('projects') ? 'text-indigo-600' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>
                    {{__('Projects')}}
                    </x-nav-link>
                </li>
                @if (Auth::user()->role === 'admin') {
                    <li>
                        <x-nav-link :href="route('admin.projects.index')" :active="request()->routeIs('admin.projects.index')" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-indigo-600 {{ Request::is('admin.projects.index') ? 'text-indigo-600' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        {{__('Manage Projects')}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-indigo-600 {{ Request::is('users.index') ? 'text-indigo-600' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        {{__('Manage Users')}}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.teams.index')" :active="request()->routeIs('admin.teams.index')" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                        <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-indigo-600 {{ Request::is('admin.teams.index') ? 'text-indigo-600' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        {{__('Manage Teams')}}
                        </x-nav-link>
                    </li>
                }
                @endif
                </ul>
            </li>
            <li>
                <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                @if($userTeams->isEmpty())
                    <!-- Message for no teams -->
                    <p class="text-sm text-gray-500 mt-2">You don't have a team.</p>
                @else
                    @foreach($userTeams as $team)
                            @foreach($team->users as $user)
                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                <li>
                                    <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
                                    <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                    <img src="{{ $user->picture ? asset('pictures/' . $user->picture) : asset('img/person-fill.svg') }}" alt="{{ $user->name }}" class="flex h-6 w-6 shrink-0 items-center object-cover justify-center rounded-lg border border-gray-200 bg-white group-hover:border-indigo-600 ">
                                    <span class="truncate">{{ $user->name }}</span>
                                    </a>
                                </li>
                                </ul>
                            @endforeach
                    @endforeach
                @endif
            </li>
            <li class="-mx-6 mt-auto">
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center ">
                                @if (Auth::user()->picture)
                                    <img src="{{ asset('pictures/' . Auth::user()->picture)}}" alt="" class="w-9 h-9 rounded-full object-cover mr-2">
                                @else
                                    <x-default-picture class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200 mr-2" />
                                @endif
                                {{ Auth::user()->name }}
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </li>
            </ul>
        </nav>
        </div>
    </div>

    <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        </button>
        <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">Dashboard</div>
        <a href="#">
        <span class="sr-only">Your profile</span>
        @if (Auth::user()->picture)
            <img class="h-8 w-8 rounded-full bg-gray-50" src="{{ asset('pictures/' . Auth::user()->picture)}}" alt="">
        @else
            <x-default-picture class="h-8 w-8 rounded-full text-gray-500" />
        @endif
        </a>
    </div>
    </div>
</div>

