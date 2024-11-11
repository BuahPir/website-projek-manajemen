<x-app-layout>
    <header class="py-5 text-4xl font-extrabold" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
        {{__('Projects')}}
    </header>
    @php
        $isLeader = \App\Models\Team::where('leader_id', auth()->id())->exists();
    @endphp
    @if ($isLeader)
        <x-button type="button" data-modal-target="static-modal" data-modal-toggle="static-modal" class="translate-y-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16">
                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2"/>
                <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0"/>
            </svg>
            <span style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">{{__('Create Projects')}}</span>
        </x-button>
    @endif
    <div id="static-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{__('Create New Project')}}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="static-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="name_project" value="{{__('Project Name')}}" />
                            <x-text-input id="name_project" name="name_project" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="description_project" value="{{__('Project Description')}}" />
                            <x-text-input id="description_project" name="description_project" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <x-primary-button type="submit" class="bg-indigo-500 text-white rounded-md px-4 py-2">Submit</x-primary-button>
                        <x-secondary-button data-modal-toggle="static-modal">Cancel</x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-8">
        @if($projects->isEmpty())
            <p class="text-gray-600">No projects have been created for your team yet.</p>
        @else
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <div class="p-4 border border-gray-200 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold">{{ $project->name }}</h3>
                        <p class="text-gray-600">{{ $project->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-app-layout>
