<div class="flex flex-col items-start space-y-2" x-data="picturePreview()">
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <div class="rounded-md bg-gray-200">
        <img id="preview" src="{{ asset('img/person-fill.svg') }}" alt="" class="w-24 h-24 rounded-md object-cover">
    </div>
    <div>
        <x-primary-button @click="document.getElementById('picture').click()" class="relative bottom-0">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                </svg>
                Upload Picture
            </div>
            <input @change="showPreview(event)" type="file" name="picture" id="picture" class="absolute inset-0 -z-10 opacity-0">
        </x-primary-button>
    </div>
    <script>
        function picturePreview() {
            return {
                showPreview: (event) => {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        document.getElementById('preview').src = src;
                    }
                }
            }
        }
    </script>
</div>
