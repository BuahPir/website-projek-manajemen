<x-app-layout>
    <x-nav-link :href="route('teams')" :active="request()->routeIs('teams')">
        <x-primary-button type="button" class="bg-indigo-500 text-white rounded-md h-full px-4 py-2">
            Back
        </x-primary-button>
    </x-nav-link>
    <form action="{{ route('teams.store') }}" method="POST" class="flex items-center space-x-2">
        <div class="mt-5 py-5 px-4">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" class="bi bi-people block h-9 w-auto fill-current text-gray-800 dark:text-gray-200 mr-2" viewBox="0 0 16 16" >
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                </svg>
                <h2 class="text-[30px] font-semibold text-gray-700 dark:text-gray-100">
                    Create Your Team
                </h2>
            </div>
            <div class="py-6">
                <x-input-label for="name_team" value="{{__('Team Name')}}" class="text-[16px]" />
                <x-text-input id="name_team" name="name_team" class="mt-1 block w-[24rem]" />
            </div>
            <div x-data="{
                open: false,
                selectedUsers: [],
                search: '',
                toggleUser(user) {
                    if (this.selectedUsers.length < 3 || this.isSelected(user)) {
                        const index = this.selectedUsers.findIndex(u => u.id === user.id);
                        if (index === -1) {
                            this.selectedUsers.push(user);
                        } else {
                            this.selectedUsers.splice(index, 1);
                        }
                    }
                },
                isSelected(user) {
                    return this.selectedUsers.some(u => u.id === user.id);
                }
            }" class="w-[24rem]">
            <h2 class="text-[16px] font-semibold mb-1 text-gray-700" >Select Users</h2>

            <!-- Multi-Select Form -->
                @csrf
            <div class="flex items-center space-x-2">
                <!-- Dropdown Menu -->
                <div class="relative inline-block w-64 mb-4">
                    <button @click="open = ! open" type="button" class="bg-white border border-gray-300 rounded-md px-4 py-2 text-left items-center justify-between mt-1 block w-[24rem]">
                        <span>
                            <template x-if="selectedUsers.length === 0">Select Users</template>
                            <template x-for="user in selectedUsers" :key="user.id">
                                <span class="inline-flex items-center bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-sm mr-1">
                                    <img :src="user.picture" alt="User Image" class="h-6 w-6 rounded-full mr-1">
                                    <span x-text="user.name"></span>
                                </span>
                            </template>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4"/>
                        </svg>
                    </button>

                    <!-- Dropdown List -->
                    <div x-show="open" @click.outside="open = false" class="absolute mt-2 w-full rounded-md bg-white shadow-lg z-10">
                        <div class="p-2">
                            <input type="text" placeholder="Search users..." x-model="search" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>

                        <ul class="py-1 max-h-60 overflow-y-auto">
                            @foreach ($users as $user)
                                <template x-if="search === '' || '{{ strtolower($user->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($user->email) }}'.includes(search.toLowerCase())">
                                    <li @click="toggleUser({
                                            id: {{ $user->id }},
                                            name: '{{ $user->name }}',
                                            picture: '{{ $user->picture ? asset('pictures/' . $user->picture) : asset('img/person-fill.svg') }}'
                                        })"
                                        class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                        <!-- Profile Picture -->
                                        <img src="{{ $user->picture ? asset('pictures/' . $user->picture) : asset('img/person-fill.svg') }}" alt="User Image" class="h-6 w-6 rounded-full mr-3">
                                        <span class="flex-1">{{ $user->name }}</span>
                                        <span x-show="selectedUsers.some(u => u.id === {{ $user->id }})" class="text-indigo-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                                                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                            </svg>
                                        </span>
                                    </li>
                                </template>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Hidden Inputs for Selected Users -->
                <template x-for="user in selectedUsers" :key="user.id">
                    <input type="hidden" name="selected_users[]" :value="user.id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-[24rem]" />
                </template>

            </div>
            <x-primary-button type="submit" class="bg-indigo-500 text-white rounded-md h-full px-4 py-2">Submit </x-primary-button>
        </div>
    </form>
</x-app-layout>
