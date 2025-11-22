@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Product Catalog')">
    <div class="min-h-screen bg-gradient-to-b from-[#f6f7f2] via-[#fbfdf9] to-[#f3f7ed] text-zinc-900">
        <nav class="sticky top-0 z-30 border-b border-zinc-200/60 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-0">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-600 text-sm font-semibold uppercase tracking-[0.4em]">rifan market</span>
                    <p class="text-sm text-zinc-700">{{ __('Semua produk') }}</p>
                </div>
                <div class="hidden items-center gap-6 text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500 sm:flex">
                    <a href="{{ route('home') }}" class="transition hover:text-emerald-600">{{ __('Home') }}</a>
                    <a href="{{ route('shop.products.index') }}" class="text-emerald-500">{{ __('Product') }}</a>
                    <a href="{{ route('shop.cart.index') }}" class="transition hover:text-emerald-600">{{ __('Keranjang') }}</a>
                    <a href="{{ route('shop.wishlist.index') }}" class="transition hover:text-emerald-600">{{ __('Wishlist') }}</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}#products" class="rounded-full border border-emerald-500/60 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500 transition hover:border-emerald-400">{{ __('Lihat katalog') }}</a>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-0">
            <header class="rounded-3xl border border-emerald-100 bg-white/80 p-6 shadow-lg shadow-emerald-100/50">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-emerald-600">{{ __('Product') }}</p>
                        <h1 class="text-3xl font-semibold text-zinc-900">{{ __('Semua produk tersedia') }}</h1>
                        <p class="text-sm text-zinc-600">{{ __('Telusuri katalog lengkap kami dengan detail harga, stok, dan simpanan favorit.') }}</p>
                    </div>
                    <div class="text-right space-y-1 text-sm text-zinc-500">
                        <p>{{ __('Items di keranjang') }}: {{ $cartQuantity }}</p>
                        <p>{{ __('Wishlist') }}: {{ $wishlistCount }}</p>
                    </div>
                </div>
            </header>

            <section class="mt-8 grid gap-6 md:grid-cols-2">
                @foreach($products as $product)
                    <article class="flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-white p-6 shadow-lg shadow-zinc-100 transition hover:shadow-emerald-200">
                        <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl bg-zinc-100 border border-zinc-200">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm uppercase tracking-[0.4em] text-zinc-400">
                                    {{ __('No Image') }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs uppercase tracking-[0.4em] text-emerald-600">{{ $product->category ?? __('Uncategorized') }}</span>
                                <span class="text-xs uppercase tracking-[0.4em] text-zinc-400">{{ $product->cut_type ?? __('Standard') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-900">{{ $product->name }}</h3>
                            <p class="text-sm text-zinc-500">{{ Str::limit($product->description ?? __('Deskripsi belum tersedia.'), 90) }}</p>
                            <div class="flex items-center justify-between text-sm font-semibold text-emerald-600">
                                <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-xs text-zinc-500">{{ __('Stok') }}: {{ number_format($product->stock) }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <form action="{{ route('shop.cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">
                                    {{ __('Tambah ke keranjang') }}
                                </button>
                            </form>
                            <form action="{{ in_array($product->id, $wishlistIds ?? []) ? route('shop.wishlist.remove', $product) : route('shop.wishlist.add') }}" method="POST" class="flex">
                                @csrf
                                @if(!in_array($product->id, $wishlistIds ?? []))
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @else
                                    @method('DELETE')
                                @endif
                                <button
                                    type="submit"
                                    class="h-11 w-11 rounded-2xl border border-zinc-200 bg-white text-zinc-500 transition hover:text-rose-500 hover:border-rose-200"
                                    aria-label="{{ in_array($product->id, $wishlistIds ?? []) ? __('Hapus wishlist') : __('Simpan wishlist') }}"
                                >
                                    @if(in_array($product->id, $wishlistIds ?? []))
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill text-rose-500" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </section>

            <div class="mt-10 flex items-center justify-center">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-layouts.plain>
