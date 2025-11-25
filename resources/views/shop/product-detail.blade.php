@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="$product->name">
    <div class="min-h-screen bg-white text-zinc-900 font-sans">
        
        {{-- Breadcrumbs (Opsional, untuk navigasi yang lebih baik) --}}
        <nav class="mx-auto max-w-7xl px-4 pt-6 text-sm text-zinc-500 sm:px-6 lg:px-8">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Home</a></li>
                <li><span class="text-zinc-300">/</span></li>
                <li class="font-medium text-zinc-900 truncate">{{ $product->name }}</li>
            </ol>
        </nav>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                
                {{-- Kolom Kiri: Galeri Gambar --}}
                <div class="product-image-wrapper relative mb-8 lg:mb-0">
                    <div class="aspect-square w-full overflow-hidden rounded-3xl bg-zinc-50 border border-zinc-100 relative group">
                        @if($product->image_url)
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center transition duration-700 group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center text-zinc-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs uppercase tracking-widest font-medium">{{ __('No Image') }}</span>
                            </div>
                        @endif

                        {{-- Badges Overlay --}}
                        <div class="absolute left-4 top-4 flex flex-col gap-2">
                            @if($product->halal_certified)
                                <span class="inline-flex items-center rounded-lg bg-white/90 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-emerald-700 shadow-sm backdrop-blur-md">
                                    <svg class="mr-1.5 h-3 w-3 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                    Halal
                                </span>
                            @endif
                            <span class="inline-flex items-center rounded-lg bg-zinc-900/80 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm backdrop-blur-md">
                                {{ $product->category ?? 'Fresh' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Detail Produk (Sticky) --}}
                <div class="product-info-wrapper lg:sticky lg:top-8 h-fit">
                    
                    {{-- Header Produk --}}
                    <div class="mb-6 border-b border-zinc-100 pb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-emerald-600">{{ $product->cut_type ?? 'Premium Cut' }}</span>
                            
                        </div>
                        <h1 class="text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl mb-4">{{ $product->name }}</h1>
                        <div class="flex items-baseline gap-4">
                            <h2 class="text-3xl font-bold text-emerald-600" data-price-display>
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </h2>
                            <span class="text-sm text-zinc-500">
                                / <span data-selected-weight-label>{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}</span>
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-zinc-500 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Stok tersedia: <strong>{{ number_format($product->stock) }}</strong>
                        </p>
                    </div>

                    {{-- Form Aksi --}}
                    <form
                        action="{{ route('shop.cart.add') }}"
                        method="POST"
                        class="space-y-8"
                        data-product-variant-form
                        data-base-price="{{ $product->price }}"
                        data-base-weight="{{ $product->weight > 0 ? $product->weight : 1 }}"
                        data-default-weight-label="{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}"
                    >
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="unit_price" value="{{ number_format($product->price, 2, '.', '') }}">
                        <input type="hidden" name="selected_weight" value="{{ $product->weight > 0 ? $product->weight : 1 }}">
                        <input type="hidden" name="selected_weight_label" value="{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}">

                        {{-- Section Pilihan Berat --}}
                        <div>
                            <h3 class="text-sm font-bold text-zinc-900 mb-3">{{ __('Pilih Ukuran / Berat') }}</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                
                                {{-- Input 1: Dropdown Varian --}}
                                <div class="relative">
                                    <label class="block text-xs font-medium text-zinc-500 mb-1.5 ml-1">{{ __('Paket Standar') }}</label>
                                    <div class="relative">
                                        <select
                                            class="appearance-none w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-8 text-sm font-medium text-zinc-900 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500 transition-all cursor-pointer"
                                            data-variant-select
                                        >
                                            <option
                                                value="{{ number_format($product->weight > 0 ? $product->weight : 1, 4, '.', '') }}"
                                                data-variant-weight="{{ number_format($product->weight > 0 ? $product->weight : 1, 6, '.', '') }}"
                                                data-variant-label="{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}"
                                            >
                                                Standar ({{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : '-' }})
                                            </option>
                                            @foreach($product->weight_variant_options as $variant)
                                                <option
                                                    value="{{ number_format($variant['kilograms'], 6, '.', '') }}"
                                                    data-variant-weight="{{ number_format($variant['kilograms'], 6, '.', '') }}"
                                                    data-variant-label="{{ $variant['label'] }}"
                                                >
                                                    {{ $variant['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Input 2: Custom Weight --}}
                                <div>
                                    <label class="block text-xs font-medium text-zinc-500 mb-1.5 ml-1">{{ __('Atau Berat Khusus (Kg)') }}</label>
                                    <div class="relative">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0.01"
                                            placeholder="Contoh: 1.5"
                                            data-custom-weight
                                            class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all"
                                        >
                                        <span class="absolute right-4 top-3 text-sm text-zinc-400 font-medium">kg</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 text-[11px] text-zinc-400">
                                *Harga akan otomatis menyesuaikan berdasarkan berat yang dipilih.
                            </p>
                        </div>

                        {{-- Quantity & Add to Cart --}}
                        <div class="flex items-end gap-4 pt-4 border-t border-zinc-100">
                            {{-- Quantity Selector --}}
                            <div class="w-32">
                                <label class="block text-xs font-bold text-zinc-900 mb-2">{{ __('Jumlah') }}</label>
                                <div class="flex items-center rounded-xl border border-zinc-200 bg-white">
                                    <button type="button" onclick="adjustQty(-1)" class="w-10 py-3 text-zinc-500 hover:text-emerald-600 transition">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full border-0 p-0 text-center text-sm font-bold text-zinc-900 focus:ring-0" readonly>
                                    <button type="button" onclick="adjustQty(1)" class="w-10 py-3 text-zinc-500 hover:text-emerald-600 transition">+</button>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex-1 flex gap-3">
                                <button type="submit" class="flex-1 flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition-all hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                                    {{ __('Keranjang') }}
                                </button>
                                
                                {{-- Wishlist Button (Isolated Form) --}}
                            </div>
                        </div>
                    </form>
                    
                    {{-- Wishlist Button placed outside main form to prevent nesting issues --}}
                    <form action="{{ in_array($product->id, $wishlistIds ?? []) ? route('shop.wishlist.remove', $product) : route('shop.wishlist.add') }}" method="POST" class="mt-3">
                        @csrf
                        @if(in_array($product->id, $wishlistIds ?? []))
                            @method('DELETE')
                        @endif
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white px-6 py-3 text-sm font-bold text-zinc-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500">
                             @if(in_array($product->id, $wishlistIds ?? []))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-rose-500" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/></svg>
                                {{ __('Hapus dari Favorit') }}
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/></svg>
                                {{ __('Simpan ke Favorit') }}
                            @endif
                        </button>
                    </form>

                    {{-- Description & Tabs (Accordion style or simple block) --}}
                    <div class="mt-8 space-y-6">
                        <div class="border-t border-zinc-100 pt-6">
                            <h3 class="text-lg font-bold text-zinc-900 mb-3">{{ __('Deskripsi Produk') }}</h3>
                            <div class="prose prose-sm prose-emerald text-zinc-600 leading-relaxed">
                                <p>{{ $product->description ?? __('Belum ada deskripsi untuk produk ini.') }}</p>
                            </div>
                        </div>

                        @if($product->cooking_tips)
                        <div class="rounded-2xl bg-amber-50 p-5 border border-amber-100">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-amber-800 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/></svg>
                                Cooking Tips
                            </h3>
                            <p class="text-sm text-amber-700 leading-relaxed">{{ $product->cooking_tips }}</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script>
        // Simple Quantity Adjuster
        function adjustQty(amount) {
            const input = document.getElementById('quantity');
            const currentVal = parseInt(input.value);
            const maxVal = parseInt(input.getAttribute('max'));
            
            let newVal = currentVal + amount;
            if (newVal < 1) newVal = 1;
            if (newVal > maxVal) newVal = maxVal;
            
            input.value = newVal;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currencyFormatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });

            const priceDisplay = document.querySelector('[data-price-display]');
            const weightDisplay = document.querySelector('[data-selected-weight-label]');
            document.querySelectorAll('[data-product-variant-form]').forEach((form) => {
                const variantSelect = form.querySelector('[data-variant-select]');
                const customInput = form.querySelector('[data-custom-weight]');
                const hiddenUnitPrice = form.querySelector('input[name="unit_price"]');
                const hiddenWeight = form.querySelector('input[name="selected_weight"]');
                const hiddenWeightLabel = form.querySelector('input[name="selected_weight_label"]');
                const basePrice = Number(form.dataset.basePrice) || 0;
                const baseWeight = Number(form.dataset.baseWeight) || 1;
                const defaultLabel = (form.dataset.defaultWeightLabel || '').trim();

                const formatCurrency = (value) => `Rp ${currencyFormatter.format(value)}`;

                const refresh = () => {
                    let weight = baseWeight;
                    let label = defaultLabel || '';

                    if (customInput && customInput.value) {
                        const customValue = Number(customInput.value);

                        if (customValue > 0) {
                            weight = customValue;
                            label = `${customValue.toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })} kg`;
                        }
                    }

                    if ((!customInput || !customInput.value) && variantSelect) {
                        const selectedOption = variantSelect.selectedOptions[0];

                        if (selectedOption) {
                            const variantWeight = Number(selectedOption.dataset.variantWeight) || 0;

                            if (variantWeight > 0) {
                                weight = variantWeight;
                                label = selectedOption.dataset.variantLabel || label;
                            }
                        }
                    }

                    // Logika Perhitungan Harga: (Harga Dasar / Berat Dasar) * Berat Dipilih
                    // Asumsi: basePrice adalah harga untuk baseWeight
                    const normalizedBaseWeight = baseWeight > 0 ? baseWeight : 1;
                    const normalizedWeight = weight > 0 ? weight : normalizedBaseWeight;
                    
                    // Rumus: (Harga Total Awal / Berat Awal) * Berat Baru
                    const pricePerKg = basePrice / normalizedBaseWeight; 
                    const price = pricePerKg * normalizedWeight;
                    
                    const finalPrice = Number.isFinite(price) ? price : basePrice;

                    if (priceDisplay) {
                        priceDisplay.textContent = formatCurrency(finalPrice);
                    }

                    if (weightDisplay && label) {
                        weightDisplay.textContent = label;
                    }

                    if (hiddenUnitPrice) {
                        hiddenUnitPrice.value = finalPrice.toFixed(2);
                    }

                    if (hiddenWeight) {
                        hiddenWeight.value = normalizedWeight;
                    }

                    if (hiddenWeightLabel) {
                        hiddenWeightLabel.value = label;
                    }
                };

                const handleVariantChange = () => {
                    if (customInput) {
                        customInput.value = ''; // Reset custom input saat dropdown dipilih
                        customInput.classList.remove('border-emerald-500', 'ring-1', 'ring-emerald-500');
                    }
                    refresh();
                };

                const handleCustomChange = () => {
                    if (variantSelect) {
                        variantSelect.selectedIndex = 0; // Reset dropdown ke default saat ngetik custom
                    }
                    if(customInput.value) {
                         customInput.classList.add('border-emerald-500', 'ring-1', 'ring-emerald-500');
                    } else {
                         customInput.classList.remove('border-emerald-500', 'ring-1', 'ring-emerald-500');
                    }

                    refresh();
                };

                variantSelect?.addEventListener('change', handleVariantChange);
                customInput?.addEventListener('input', handleCustomChange);

                refresh();
            });
        });
    </script>
</x-layouts.plain>