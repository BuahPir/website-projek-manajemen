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
    <div>
        <x-button type="button" data-modal-target="static-modal" data-modal-toggle="static-modal" class="translate-y-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
            </svg>
            <span style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">{{__('Create Teams')}}</span>
        </x-button>
        <div id="static-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex justify-between items-start p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Create Your Team
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="static-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('teams.store') }}" method="POST" x-data="{
                        open: false,
                        selectedUsers: [],
                        search: '',
                        toggleUser(user) {
                            const index = this.selectedUsers.findIndex(u => u.id === user.id);
                            if (index === -1) {
                                this.selectedUsers.push(user);
                            } else {
                                this.selectedUsers.splice(index, 1);
                            }
                        },
                        isSelected(user) {
                            return this.selectedUsers.some(u => u.id === user.id);
                        }
                    }">
                        @csrf
                        <div class="p-6 space-y-6">
                            <div>
                                <x-input-label for="name_team" value="{{__('Team Name')}}" />
                                <x-text-input id="name_team" name="name_team" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-gray-700">Select Users</h2>
                                <div class="relative inline-block w-full mt-2">
                                    <button @click="open = !open" type="button" class="w-full bg-white border border-gray-300 rounded-md px-4 py-2 text-left flex items-center justify-between h-[42px]">
                                        <span>
                                            <template x-if="selectedUsers.length === 0">Select Users</template>
                                            <template x-for="user in selectedUsers" :key="user.id">
                                                <span class="inline-flex items-center bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-sm mr-1 translate-y-[1.5px]">
                                                    <img :src="user.picture" alt="User Image" class="h-6 w-6 rounded-full mr-1">
                                                    <span x-text="user.name"></span>
                                                </span>
                                            </template>
                                        </span>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute mt-2 w-full rounded-md bg-white shadow-lg z-10">
                                        <div class="p-2">
                                            <input type="text" placeholder="Search users..." x-model="search" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                        </div>

                                        <ul class="py-1 max-h-60 overflow-y-auto">
                                            @foreach ($users->where('id', '!=', auth()->id()) as $user)
                                                <template x-if="search === '' || '{{ strtolower($user->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($user->email) }}'.includes(search.toLowerCase())">
                                                    <li @click="toggleUser({
                                                            id: {{ $user->id }},
                                                            name: '{{ $user->name }}',
                                                            picture: '{{ $user->picture ? asset('pictures/' . $user->picture) : asset('img/person-fill.svg') }}'
                                                        })"
                                                        class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                        <img src="{{ $user->picture ? asset('pictures/' . $user->picture) : asset('img/person-fill.svg') }}" alt="User Image" class="h-6 w-6 rounded-full mr-3">
                                                        <span class="flex-1">{{ $user->name }}</span>
                                                        <span x-show="isSelected({{ json_encode($user) }})" class="text-indigo-600">
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
                            </div>
                        </div>

                        <!-- Hidden Inputs for Selected Users -->
                        <template x-for="user in selectedUsers" :key="user.id">
                            <input type="hidden" name="selected_users[]" :value="user.id" />
                        </template>

                        <!-- Modal footer -->
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <x-primary-button type="submit" class="bg-indigo-500 text-white rounded-md px-4 py-2">Submit</x-primary-button>
                            <x-secondary-button data-modal-toggle="static-modal">Cancel</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="delete-team-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-indigo-400 hover:text-indigo-800 translate-y-1 translate-x-6 delete-team-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-team-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    // Prevent the default button action
                    event.preventDefault();

                    Swal.fire({
                        title: 'Apakah kamu serius?',
                        text: "Kamu tidak akan bisa mengembalikannya lagi",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form only if the user confirms
                            button.closest('.delete-team-form').submit();
                        }
                    });
                });
            });
        });
    </script>

</x-app-layout>
