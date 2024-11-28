<x-app-layout>
    <!-- Button to open modal -->
    <button id="openModalButton" class="px-4 py-2 bg-indigo-500 text-white rounded-md">
        Open Modal
    </button>

    <!-- Modal -->
    <div id="myModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-96">
            <h2 class="text-lg font-bold mb-4">Modal Content</h2>
            <p>This is the modal content. Right</p>
            <button id="closeModalButton" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md">
                Close Modal
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('myModal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');

    // Store the original URL to revert back later
    const originalUrl = window.location.href;

    // Open Modal and Change URL
    openModalButton.addEventListener('click', function () {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Change the URL without redirecting
        const newUrl = `${originalUrl}?modal=open`;
        history.pushState({ modalOpen: true }, '', newUrl);
    });

    // Close Modal and Revert URL
    closeModalButton.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Revert back to the original URL
        history.pushState({ modalOpen: false }, '', originalUrl);
    });

    // Handle Back/Forward Navigation
    window.addEventListener('popstate', function (event) {
        if (event.state && event.state.modalOpen) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});

    </script>
</x-app-layout>
