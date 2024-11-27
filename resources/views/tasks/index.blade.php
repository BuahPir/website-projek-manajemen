<x-app-layout>
    <style>
        /* Custom scrollbar for the scrollable comment container */
        .scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: #c4c4c4;
            border-radius: 4px;
        }

        .scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
        }
    </style>
    <h1 class="text-2xl font-bold">{{ $project->name }} - Tasks</h1>
    @php
        $isLeader = \App\Models\Team::where('leader_id', auth()->id())->exists();
    @endphp
    @if ($isLeader)
        <x-button type="button" data-modal-target="static-modal" data-modal-toggle="static-modal" class="translate-y-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16">
                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2"/>
                <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0"/>
            </svg>
            <span style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">{{__('Create Tasks')}}</span>
        </x-button>
    @endif
    <div id="static-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{__('Create New Task')}}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="static-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="name" value="{{ __('Task Name') }}" />
                            <x-text-input id="name" name="name" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <x-input-label for="description" value="{{ __('Task Description') }}" />
                            <x-text-input id="description" name="description" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <x-input-label for="status" value="{{ __('Status') }}" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="process">Process</option>
                                <option value="done">Done</option>
                            </select>
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
        <ul>
            @if($project->tasks->isEmpty())
                <p class="text-gray-500">No tasks have been created for this project.</p>
            @else
            <ul class="space-y-2">
                @foreach ($project->tasks as $task)
                    <li class="bg-gray-100 shadow-md p-4 rounded-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-semibold text-lg">{{ $task->name }}</span>
                                <p class="text-gray-700 mt-1">{{ $task->description }}</p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Status Label -->
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                                    @if ($task->status === 'process')
                                        <button data-modal-target="crud-modal-{{ $task->id }}"
                                        data-modal-toggle="crud-modal-{{ $task->id }}"
                                        class="bg-indigo-500 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-indigo-600 translate-y-[0.01rem]" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0"/>
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Main modal -->
                                    <div id="crud-modal-{{ $task->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div class="flex justify-between items-start p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        {{__('New Activity')}}
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Modal body -->
                                                <form action="{{ route('projects.tasks.activities.store', [$project->id, $task->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="p-6 space-y-6">
                                                        <div>
                                                            <x-input-label for="activity_name" value="{{ __('Activity Name') }}" />
                                                            <x-text-input id="activity_name" name="activity_name" class="mt-1 block w-full" />
                                                        </div>

                                                        <div>
                                                            <x-input-label for="description" value="{{ __('Description') }}" />
                                                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="activity_date" value="{{ __('Activity Date') }}" />
                                                            <div class="relative max-w-sm">
                                                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                                  </svg>
                                                                </div>
                                                                <input datepicker id="default-datepicker" id="activity_date" name="activity_date"type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                                            </div>
                                                        </div>


                                                        <div>
                                                            <x-input-label for="file_path">Upload file</x-input-label>
                                                            <input name="file_path" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_path" type="file">
                                                        </div>
                                                    </div>


                                                    <!-- Modal footer -->
                                                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <x-primary-button type="submit" class="bg-indigo-500 text-white rounded-md px-4 py-2">Submit</x-primary-button>
                                                        <x-secondary-button data-modal-toggle="crud-modal">Cancel</x-secondary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <!-- Timeline toggle -->
                                <button
                                    data-modal-target="timeline-modal-{{ $task->id }}"
                                    data-modal-toggle="timeline-modal-{{ $task->id }}"
                                    class="bg-indigo-500 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-indigo-600"
                                    type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-arrow-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5"/>
                                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                    </svg>
                                </button>

                                <!-- Main modal -->
                                <div id="timeline-modal-{{ $task->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-4xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Changelog for {{ $task->name }}
                                                </h3>
                                                <button
                                                    type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-toggle="timeline-modal-{{ $task->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5">
                                                    <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                                                        @foreach ($task->activities->where('task_id', $task->id) as $activity)
                                                            <li class="mb-10 ms-8">
                                                                <!-- Timeline Circle -->
                                                                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                                                    <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"/>
                                                                    </svg>
                                                                </span>

                                                                <!-- Activity Information -->
                                                                <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                                                    {{ $activity->activity_name }}
                                                                    <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">
                                                                        {{ $activity->activity_date->format('M d, Y') }}
                                                                    </span>
                                                                </h3>

                                                                <p class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">
                                                                    {{ $activity->description }}
                                                                </p>

                                                                <!-- Download Button -->
                                                                @if($activity->file_path)
                                                                    <a href="{{asset('/pictures/'.$activity->file_path)}}" download class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                                        <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                                                            <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                                                        </svg>
                                                                        Download
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ol>

                                                    <div class="max-h-20 overflow-y-auto scrollbar">
                                                        @foreach ($task->comments as $comment)
                                                            <div class="flex items-start gap-2.5">
                                                                <img class="w-8 h-8 rounded-full" src="{{ $comment->user->picture ? asset('pictures/' . $comment->user->picture) : asset('img/person-fill.svg') }}" alt="{{ $comment->user->name }}">
                                                                <div class="flex flex-col w-full max-w-[320px] leading-1.5">
                                                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                                                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('H:i') }}</span>
                                                                    </div>
                                                                    <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">{{ $comment->content }}</p>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        @endforeach
                                                    </div>

                                                    <form action="{{ route('projects.tasks.comments.store', ['projectId' => $project->id, 'taskId' => $task->id]) }}" method="POST">
                                                        @csrf
                                                        <label for="chat" class="sr-only">Your message</label>
                                                        <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                                                            <textarea id="chat" name="content" rows="1" class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your message..."></textarea>
                                                            <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                                                                <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                                    <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z"/>
                                                                </svg>
                                                                <span class="sr-only">Send message</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                @if(Auth::id() === $project->team->leader_id)
                                    <form action="{{ route('projects.tasks.updateStatus', [$project->id, $task->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-indigo-600">
                                            {{ $task->status === 'process' ? 'Mark as Done' : 'Mark as Process' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" class="delete-task-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @endif
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalButtons = document.querySelectorAll('[data-modal-toggle]');

            modalButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modalId = button.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);

                    // Show the modal
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    // Change the URL without reloading
                    const newUrl = button.getAttribute('data-url');
                    if (newUrl) {
                        history.pushState(null, '', newUrl);
                    }
                });
            });

            // Handle modal close and revert URL
            const closeButtons = document.querySelectorAll('[data-modal-toggle]');
            closeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modalId = button.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);

                    // Hide the modal
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');

                    // Revert the URL to the original without reloading
                    const originalUrl = window.location.pathname; // Adjust this if needed
                    history.pushState(null, '', originalUrl);
                });
            });
        });

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
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            // Display error message
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
</x-app-layout>
