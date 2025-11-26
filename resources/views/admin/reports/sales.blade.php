<x-layouts.app :title="__('Laporan Penjualan')">
    <div class="min-h-screen bg-zinc-50 font-sans text-zinc-900 p-4 lg:p-8 rounded-2xl">
    <!-- Breadcrumbs ke admin-->
    <nav class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-0">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a></li>
            <li><span class="text-zinc-300">/</span></li>
            <li class="font-medium text-zinc-900 truncate">Laporan Penjualan</li>
        </ol>
    </nav>


        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900">{{ __('Laporan Penjualan') }}</h1>
            <p class="mt-1 text-sm text-zinc-500">{{ __('Analisa performa penjualan, filter berdasarkan tanggal, dan ekspor data.') }}</p>
        </div>

        {{-- Filter Section --}}
        <section class="mb-8 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                
                {{-- Form Inputs --}}
                <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex-1 w-full">
                    <div class="flex flex-col gap-4 md:flex-row md:items-end">
                        <div class="w-full md:w-auto">
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-zinc-500">
                                {{ __('Dari Tanggal') }}
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>
                                </div>
                                <input
                                    type="date"
                                    name="date_from"
                                    value="{{ $filters['dateFrom'] ?? '' }}"
                                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 pl-10 pr-4 py-2.5 text-sm font-semibold text-zinc-900 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                                />
                            </div>
                        </div>

                        <div class="hidden md:block pb-3 text-zinc-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
                        </div>

                        <div class="w-full md:w-auto">
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-zinc-500">
                                {{ __('Sampai Tanggal') }}
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>
                                </div>
                                <input
                                    type="date"
                                    name="date_to"
                                    value="{{ $filters['dateTo'] ?? '' }}"
                                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 pl-10 pr-4 py-2.5 text-sm font-semibold text-zinc-900 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl border border-zinc-200 bg-white px-5 py-2.5 text-sm font-bold text-zinc-700 shadow-sm transition hover:bg-zinc-50 hover:text-emerald-600 hover:border-emerald-200"
                        >
                            {{ __('Terapkan Filter') }}
                        </button>
                    </div>
                </form>

                {{-- Export Button --}}
                <div class="mt-4 lg:mt-0">
                    <form action="{{ route('admin.reports.sales') }}" method="GET">
                        <input type="hidden" name="date_from" value="{{ $filters['dateFrom'] ?? '' }}">
                        <input type="hidden" name="date_to" value="{{ $filters['dateTo'] ?? '' }}">
                        <button
                            type="submit"
                            name="export"
                            value="1"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-emerald-200 transition hover:bg-emerald-700 hover:-translate-y-0.5"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/><path d="M4.151 15.25 6.645 15.51 9.14 15.77 11.636 16.03"/></svg>
                            {{ __('Download Excel') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>

        {{-- Summary Cards --}}
        <div class="grid gap-6 md:grid-cols-3 mb-8">
            {{-- Active Range --}}
            <article class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-zinc-500">{{ __('Periode Laporan') }}</p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-bold text-zinc-600">
                        {{ $filters['dateFrom'] ? date('d M Y', strtotime($filters['dateFrom'])) : 'Awal' }}
                    </span>
                    <span class="text-zinc-400">&rarr;</span>
                    <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-bold text-zinc-600">
                        {{ $filters['dateTo'] ? date('d M Y', strtotime($filters['dateTo'])) : 'Hari Ini' }}
                    </span>
                </div>
            </article>

            {{-- Order Count --}}
            <article class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-zinc-500">{{ __('Total Transaksi') }}</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($summary['orders']) }}</p>
            </article>

            {{-- Revenue --}}
            <article class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-zinc-500">{{ __('Total Pendapatan') }}</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">Rp{{ number_format($summary['revenue'], 0, ',', '.') }}</p>
            </article>
        </div>

        {{-- Data Table --}}
        <section class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-zinc-900">{{ __('Rincian Pesanan') }}</h2>
                    <p class="text-xs text-zinc-500">{{ __('Daftar transaksi berdasarkan filter di atas.') }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100 text-left text-sm">
                    <thead>
                        <tr class="bg-zinc-50/50">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Order ID') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Pelanggan') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Total') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Pembayaran') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Tanggal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @forelse($orders as $order)
                            <tr class="group transition hover:bg-zinc-50/80">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono font-bold text-emerald-600">#{{ $order->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-zinc-900">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $order->customer_email }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-zinc-900">
                                    Rp{{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match($order->status) {
                                            'completed', 'shipped' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                            'processing', 'paid' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                            'cancelled', 'failed' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                                            default => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                     @php
                                        $paymentClass = match($order->payment_status) {
                                            'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                            'unpaid' => 'bg-zinc-100 text-zinc-600 ring-zinc-500/20',
                                            default => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $paymentClass }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-zinc-500 text-xs">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="rounded-full bg-zinc-50 p-4 mb-3">
                                            <svg class="h-8 w-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-zinc-900">{{ __('Data Tidak Ditemukan') }}</h3>
                                        <p class="text-xs text-zinc-500 mt-1">{{ __('Tidak ada transaksi pada rentang tanggal yang dipilih.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="border-t border-zinc-100 bg-zinc-50 px-6 py-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>