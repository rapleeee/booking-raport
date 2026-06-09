@props([
    'href'     => '#',
    'active'   => false,
    'icon'     => '',
    'label'    => '',
    'collapsed'=> false,
])

<a
    href="{{ $href }}"
    title="{{ $label }}"
    @class([
        'flex items-center gap-3 px-2 py-2 rounded-lg text-sm font-medium transition-colors duration-150',
        'bg-indigo-600 text-white'         => $active,
        'text-gray-400 hover:bg-gray-800 hover:text-white' => ! $active,
    ])
>
    <svg class="shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icon }}"/>
    </svg>
    <span x-show="open" x-transition.opacity class="truncate">{{ $label }}</span>
</a>