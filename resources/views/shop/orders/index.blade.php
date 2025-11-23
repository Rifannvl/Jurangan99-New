@php
    use Illuminate\Support\Str;
    
    // Helper sederhana untuk warna status (bisa dipindah ke Model/Helper nanti)
    $getStatusClasses = function($status) {
        return match(Str::lower($status)) {
            'paid', 'completed', 'success', 'dikirim' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'pending', 'unpaid', 'menunggu', 'waiting' => 'bg-amber-100 text-amber-700 border-amber-200',
            'cancelled', 'failed', 'batal' => 'bg-rose-100 text-rose-700 border-rose-200',
            default => 'bg-zinc-100 text-zinc-700 border-zinc-200',
        };
    };
@endphp

<x-layouts.plain :title="__('My Orders')">
    <div class="min-h-screen bg-white pb-20 pt-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-900">{{ __('Pesanan Saya') }}</h1>
                    <p class="mt-1 text-sm text-zinc-500">{{ __('Riwayat pembelian dan status pengiriman Anda.') }}</p>
                </div>
                
                {{-- Tombol Belanja Lagi (Opsional) --}}
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-50 hover:text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Belanja Baru') }}
                </a>
            </div>

            @if($orders->isEmpty())
                {{-- Empty State (Desain Kosong yang Menarik) --}}
                <div class="flex min-h-[400px] flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-white p-8 text-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-zinc-50 ring-1 ring-zinc-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-zinc-900">{{ __('Belum ada pesanan') }}</h3>
                    <p class="mt-2 text-sm text-zinc-500 max-w-sm">{{ __('Tampaknya Anda belum pernah berbelanja. Yuk, mulai cari produk daging segar favoritmu sekarang!') }}</p>
                    <a href="{{ route('home') }}" class="mt-6 rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        {{ __('Mulai Belanja') }}
                    </a>
                </div>
            @else
                {{-- Orders List --}}
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <a href="{{ route('shop.orders.show', $order) }}" 
                           class="group relative flex flex-col gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition-all hover:border-emerald-500 hover:shadow-md md:flex-row md:items-center md:justify-between">
                            
                            {{-- Left Side: Icon & Basic Info --}}
                            <div class="flex items-start gap-4">
                                {{-- Decorative Icon Box --}}
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-zinc-50 text-emerald-600 ring-1 ring-zinc-100 group-hover:bg-emerald-50 group-hover:ring-emerald-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>

                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-zinc-900 group-hover:text-emerald-700 transition">
                                            Order #{{ $order->id }}
                                        </h3>
                                        <span class="hidden text-zinc-300 md:inline">&bull;</span>
                                        <span class="text-xs text-zinc-500 md:text-sm">
                                            {{ $order->created_at->translatedFormat('d F Y, H:i') }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-zinc-500">
                                        Total Pembayaran: <span class="font-semibold text-zinc-900">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Right Side: Status & Action Arrow --}}
                            <div class="flex items-center justify-between gap-4 border-t border-zinc-100 pt-4 md:border-none md:pt-0">
                                {{-- Status Badge --}}
                                <div class="px-3 py-1 rounded-full border text-xs font-bold uppercase tracking-wider {{ $getStatusClasses($order->status) }}">
                                    {{ $order->status }}
                                </div>
                                
                                {{-- Arrow Icon (Hidden on mobile usually, but kept for clarity) --}}
                                <div class="text-zinc-300 transition group-hover:translate-x-1 group-hover:text-emerald-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.plain>