<button type="button" {{ $attributes->merge(['class' =>"flex items-center gap-2 rounded-md bg-indigo-50 px-3.5 py-2.5 text-sm font-semibold text-gray-700 hover:text-indigo-700 shadow-sm hover:bg-indigo-100"]) }}>
    {{ $slot }}
</button>
