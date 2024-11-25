<x-app-layout>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Teams List</h1>

    <table class="min-w-full bg-white border border-gray-300 shadow-md">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Team Name</th>
                <th class="py-2 px-4 border-b text-left">Leader</th>
                <th class="py-2 px-4 border-b text-left">Members</th>
                <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $team->name }}</td>
                    <td class="py-2 px-4 border-b">
                        @if ($team->leader)
                            <span>{{ $team->leader->name }}</span>
                        @else
                            <span class="text-red-500">No Leader</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <ul>
                            @foreach ($team->users as $user)
                                <li>{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
