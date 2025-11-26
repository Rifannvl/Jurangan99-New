<x-layouts.app :title="__('Admin Dashboard')">
    <div class="min-h-screen bg-zinc-50 font-sans text-zinc-900 p-4 lg:p-8 rounded-2xl">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900">{{ __('Dashboard Overview') }}</h1>
            <p class="mt-1 text-sm text-zinc-500">{{ __('Ringkasan aktivitas platform dan statistik terkini.') }}</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid gap-6 md:grid-cols-3 mb-8">
            {{-- Card 1: Total Users --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500">{{ __('Total Pengguna') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($userCount) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/></svg>
                </div>
            </div>

            {{-- Card 2: Active Sessions --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500">{{ __('Sesi Aktif') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($sessionCount) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M8 3a5 5 0 1 0 0 10A5 5 0 0 0 8 3M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8"/><path d="M8 4.5a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7"/></svg>
                </div>
            </div>

            {{-- Card 3: Queued Jobs --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500">{{ __('Antrian Sistem') }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($jobCount) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- KOLOM KIRI: Recent Users --}}
            <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white shadow-sm">
                <div class="border-b border-zinc-100 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-zinc-900">{{ __('Pengguna Terbaru') }}</h2>
                        <p class="text-xs text-zinc-500">{{ __('Daftar user yang baru mendaftar.') }}</p>
                    </div>
                    <a href="#" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">{{ __('Lihat Semua') }} &rarr;</a>
                </div>

                <div class="divide-y divide-zinc-100">
                    @forelse($recentUsers as $recentUser)
                        <div class="flex items-center justify-between p-4 hover:bg-zinc-50/50 transition">
                            <div class="flex items-center gap-4">
                                {{-- Avatar Initials --}}
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 text-sm font-bold text-zinc-600">
                                    {{ $recentUser->initials() }}
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">{{ $recentUser->name }}</p>
                                    <p class="text-xs text-zinc-500">{{ $recentUser->email }}</p>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <span class="inline-flex items-center rounded-md bg-zinc-50 px-2 py-1 text-xs font-medium text-zinc-600 ring-1 ring-inset ring-zinc-500/10 mb-1">
                                    {{ ucfirst($recentUser->role) }}
                                </span>
                                <p class="text-[10px] text-zinc-400">
                                    {{ $recentUser->created_at?->diffForHumans() ?? '-' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-zinc-500">
                            <p class="text-sm">{{ __('Belum ada pengguna.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- KOLOM KANAN: Quick Actions / Reports --}}
            <div class="space-y-6">
                
                {{-- Sales Report Card --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-emerald-50 opacity-50 blur-2xl"></div>
                    
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0z"/><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/></svg>
                            </div>
                            <h2 class="text-lg font-bold text-zinc-900">{{ __('Laporan Penjualan') }}</h2>
                        </div>
                        
                        <p class="text-sm text-zinc-500 mb-6 leading-relaxed">
                            {{ __('Ekspor data rekapitulasi penjualan dalam format Excel untuk keperluan audit dan pelaporan bulanan.') }}
                        </p>

                        <a
                            href="{{ route('admin.reports.sales') }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-md shadow-emerald-200 transition hover:bg-emerald-700 hover:-translate-y-0.5"
                        >
                            {{ __('Download Laporan') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- System Status (Optional Extra) --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-500">{{ __('Status Sistem') }}</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-600">Database</span>
                            <span class="flex items-center gap-1.5 text-emerald-600 font-medium">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Connected
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-600">Storage</span>
                            <span class="flex items-center gap-1.5 text-emerald-600 font-medium">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> OK
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-600">Cache</span>
                            <span class="flex items-center gap-1.5 text-emerald-600 font-medium">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Running
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>