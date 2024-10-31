<div class="flex flex-col items-center space-y-2" x-data="picturePreview()">
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <div class="rounded-full bg-gray-200">
        @if (Auth::user()->picture)
            <img id="preview" src="{{ asset('pictures/' . Auth::user()->picture)}}" alt="" class="w-48 h-48 rounded-full object-cover">
        @else
            <img id="preview" src="{{ asset('img/person-fill.svg') }}" alt="" class="w-48 h-48 rounded-full object-cover">
        @endif
    </div>
    <div>
        <x-secondary-button @click="document.getElementById('picture').click()" class="relative">
            <div class="flex items-center">
                Upload Picture
            </div>
            <input @change="showPreview(event)" type="file" name="picture" id="picture" class="absolute inset-0 -z-10 opacity-0">
        </x-secondary-button>
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
