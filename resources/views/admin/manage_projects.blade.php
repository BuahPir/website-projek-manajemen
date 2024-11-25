<x-app-layout>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Projects List</h1>

    <table class="min-w-full bg-white border border-gray-300 shadow-md">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-left">Project Name</th>
                <th class="py-2 px-4 border-b text-left">Team</th>
                <th class="py-2 px-4 border-b text-left">Leader</th>
                <th class="py-2 px-4 border-b text-left">Created At</th>
                <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $project->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $project->team->name ?? 'No Team Assigned' }}</td>
                    <td class="py-2 px-4 border-b">
                        {{ $project->team->leader->name ?? 'No Leader Assigned' }}
                    </td>
                    <td class="py-2 px-4 border-b">{{ $project->created_at->format('Y-m-d') }}</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-4" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-app-layout>
