<!-- Overlay backdrop for mobile -->
<div 
    x-show="open && isMobile" 
    @click="open = false"
    x-transition.opacity
    class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
></div>

<aside
    :class="[
        isMobile ? (open ? 'translate-x-0 w-64' : '-translate-x-full w-64') : (open ? 'w-64' : 'w-16')
    ]"
    class="fixed inset-y-0 left-0 z-50 flex flex-col h-screen bg-gray-900 text-white transition-all duration-300 ease-in-out lg:relative lg:shrink-0"
>
    <!-- Toggle Button (Desktop Only) -->
    <button
        @click="open = !open"
        class="hidden lg:flex absolute -right-3 top-6 z-10 items-center justify-center w-6 h-6 rounded-full bg-gray-900 border border-gray-700 text-gray-400 hover:text-white transition"
    >
        <svg x-show="open" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <svg x-show="!open" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Logo / Brand --}}
    <div class="flex items-center gap-3 px-4 h-16 border-b border-gray-700 shrink-0">
        <a href="{{ route('admin.index') }}" class="flex items-center gap-3 min-w-0">
            <span class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </span>
            <span x-show="open" x-transition.opacity class="text-sm font-semibold text-white whitespace-nowrap">
                Admin Panel
            </span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-2 space-y-1">

        <p x-show="open" x-transition.opacity class="px-2 mb-1 text-xs font-semibold uppercase tracking-wider text-gray-500">Main</p>

        @php
            $navItems = [
                [
                    'label'  => 'Dashboard',
                    'route'  => 'admin.index',
                    'match'  => 'admin.index',
                    'icon'   => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                    'group'  => 'main',
                ],
                [
                    'label'  => 'Wali Kelas',
                    'route'  => 'admin.walikelas.index',
                    'match'  => 'admin.walikelas.*',
                    'icon'   => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                    'group'  => 'kelola',
                ],
                [
                    'label'  => 'Kelas',
                    'route'  => 'admin.kelas.index',
                    'match'  => 'admin.kelas.*',
                    'icon'   => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    'group'  => 'kelola',
                ],
                [
                    'label'  => 'Siswa',
                    'route'  => 'admin.siswa.index',
                    'match'  => 'admin.siswa.*',
                    'icon'   => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                    'group'  => 'kelola',
                ],
                [
                    'label'  => 'Jadwal Booking',
                    'route'  => 'admin.schedule_dates.index',
                    'match'  => 'admin.schedule_dates.*',
                    'icon'   => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'group'  => 'kelola',
                ],
                [
                    'label'  => 'Laporan',
                    'route'  => 'admin.reports.index',
                    'match'  => 'admin.reports.*',
                    'icon'   => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'group'  => 'kelola',
                ],
                [
                    'label'  => 'Pengaturan',
                    'route'  => 'profile.edit',
                    'match'  => 'profile.edit',
                    'icon'   => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                    'group'  => 'sistem',
                ],
            ];

            $currentGroup = 'main';
        @endphp

        @foreach ($navItems as $item)
            @if ($item['group'] !== $currentGroup)
                @php $currentGroup = $item['group'] @endphp
                <p x-show="open" x-transition.opacity class="px-2 pt-4 mb-1 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    {{ ucfirst($item['group']) }}
                </p>
            @endif

            @php
                $isActive = request()->routeIs($item['match']);
                $routeExists = \Illuminate\Support\Facades\Route::has($item['route']);
                $href = $routeExists ? route($item['route']) : '#';
            @endphp

            <a
                href="{{ $href }}"
                title="{{ $item['label'] }}"
                @class([
                    'flex items-center gap-3 px-2 py-2 rounded-lg text-sm font-medium transition-colors duration-150',
                    'bg-indigo-600 text-white'                          => $isActive,
                    'text-gray-400 hover:bg-gray-800 hover:text-white'  => !$isActive,
                ])
            >
                <svg class="shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                </svg>
                <span x-show="open" x-transition.opacity class="truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach

    </nav>

    {{-- User Profile Footer --}}
    <div class="border-t border-gray-700 p-3 shrink-0">
        <div class="flex items-center gap-3">
            <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-indigo-500 text-white text-xs font-bold uppercase">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div x-show="open" x-transition.opacity class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
            <div x-show="open" x-transition.opacity class="shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Log Out" class="text-gray-400 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>