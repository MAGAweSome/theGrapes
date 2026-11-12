@props([
    'sidebar' => false,
])

@php
    $tag = $attributes->has('href') ? 'a' : 'span';
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold tracking-[0.22em] text-white shadow-2xl shadow-black/20 backdrop-blur-xl']) }}>
    The Grapes
</{{ $tag }}>
