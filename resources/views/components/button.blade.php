<!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
@props(['variant' => 'primary, // primary, secondary, danger', 
        'type' => 'button'
])

@php
$base = 'inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2';

$variants = [
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
    'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $base . ' ' . ($variants[$variant] ?? $variants['primary'])]) }}>
    {{ $slot }}
</button>