@php
    use Illuminate\Support\Str;

    $featured = $recipes->first();
@endphp

<x-layouts.app :title="__('Resep')">
    <div class="space-y-8">
        <section class="rounded-2xl border border-zinc-200 bg-white/80 p-6 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="grid gap-6 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-500">{{ __('Content Marketing') }}</p>
                    <h1 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $featured->title ?? __('Cara Membuat Steak Sempurna') }}</h1>
                    <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-300">
                        {{ $featured->excerpt ?? __('Pilih potongan daging terbaik, panggang dengan suhu tepat, dan sajikan dengan saus pilihan.') }}
                    </p>
                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <a
                            href="{{ $featured->product_link ?? route('shop.products.index') }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm shadow-emerald-600/30 transition hover:bg-emerald-700"
                        >
                            {{ $featured->product_link_text ?? __('Beli Tenderloin di sini') }}
                        </a>
                        <span class="text-xs text-zinc-400">{{ $featured?->published_at?->format('d F Y') ?? now()->format('d F Y') }}</span>
                    </div>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-emerald-700">{{ __('Tahapan') }}</p>
                    <ol class="mt-4 space-y-3 text-sm text-zinc-600">
                        <li>{{ __('1. Marinasi daging dengan garam, merica, dan rempah selama 1 jam.') }}</li>
                        <li>{{ __('2. Panaskan panggangan hingga 220°C dan panggang selama 2-3 menit tiap sisi.') }}</li>
                        <li>{{ __('3. Istirahatkan daging 5 menit sebelum diiris agar jus tersebar merata.') }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="space-y-4">
            <header class="flex flex-col gap-1">
                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-500">{{ __('Inspirasi Resep') }}</p>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Artikel resep terbaru') }}</h2>
            </header>

            <div class="grid gap-6 lg:grid-cols-2">
                @forelse($recipes as $recipe)
                    <article class="flex h-full flex-col gap-4 rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm shadow-zinc-900/5 dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-500">{{ $recipe->published_at?->format('d F Y') }}</p>
                                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $recipe->title }}</h3>
                            </div>
                            <span class="rounded-full border border-zinc-200 px-3 py-1 text-xs font-semibold text-zinc-500">{{ Str::limit($recipe->slug, 8, '') }}</span>
                        </div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $recipe->excerpt ?? Str::limit($recipe->body, 150) }}</p>
                        <div class="mt-auto flex items-center justify-between gap-3">
                            <a
                                href="{{ $recipe->product_link ?? route('shop.products.index') }}"
                                class="text-sm font-semibold text-emerald-600 hover:text-emerald-500"
                                rel="noreferrer"
                            >
                                {{ $recipe->product_link_text ?? __('Beli Tenderloin di sini') }} →
                            </a>
                            <span class="text-xs text-zinc-400">{{ __('Klik untuk melihat produk') }}</span>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-zinc-500">{{ __('Belum ada resep yang dipublikasikan. Cek kembali nanti.') }}</p>
                @endforelse
            </div>

            {{ $recipes->links() }}
        </section>
    </div>
</x-layouts.app>
