@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group flex gap-x-3 rounded-md text-sm font-semibold leading-6 text-indigo-600'
            : 'group flex gap-x-3 rounded-md text-sm font-semibold leading-6 text-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
