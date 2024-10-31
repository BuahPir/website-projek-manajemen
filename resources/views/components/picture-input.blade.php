<div class="flex flex-col items-start space-y-2" x-data="picturePreview()">
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <div class="rounded-md bg-gray-200">
        <img id="preview" src="{{ asset('img/person-fill.svg') }}" alt="" class="w-24 h-24 rounded-md object-cover">
    </div>
    <div>
        <x-primary-button @click="document.getElementById('picture').click()" class="relative bottom-0">
            <div class="flex items-center">
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
