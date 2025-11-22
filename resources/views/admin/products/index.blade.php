@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="__('Products')">
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Products') }}</h1>
                <p class="text-sm text-zinc-500">{{ __('Manage your catalog and attachments.') }}</p>
            </div>
            <a
                href="{{ route('admin.products.create') }}"
                class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600"
            >{{ __('Add product') }}</a>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-900">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white/80 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="divide-y divide-zinc-100 dark:divide-zinc-700">
                <div class="grid grid-cols-2 gap-4 px-5 py-4 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-300 lg:grid-cols-6">
                    <span class="lg:col-span-2">{{ __('Product') }}</span>
                    <span>{{ __('Price') }}</span>
                    <span>{{ __('Stock') }}</span>
                    <span>{{ __('Image') }}</span>
                    <span class="text-end">{{ __('Actions') }}</span>
                </div>

                @forelse($products as $product)
                    <div class="grid grid-cols-2 gap-4 px-5 py-4 text-sm text-zinc-700 dark:text-white lg:grid-cols-6">
                        <div class="flex items-center gap-3">
                            @if($product->image_url)
                                <span class="h-10 w-10 overflow-hidden rounded-xl bg-zinc-100">
                                    <img src="{{ $product->image_url }}" alt="" class="h-full w-full object-cover" />
                                </span>
                            @else
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-200 text-xs text-zinc-500">{{ Str::substr($product->name, 0, 2) }}</span>
                            @endif

                            <div>
                                <p class="font-semibold">{{ $product->name }}</p>
                                <p class="text-xs uppercase tracking-wide text-zinc-500">{{ $product->slug }}</p>
                            </div>
                        </div>
                        <div>{{ number_format($product->price, 2) }}</div>
                        <div>{{ number_format($product->stock) }}</div>
                        <div>
                            <span class="inline-flex rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-zinc-700">{{ $product->image_path ? __('Stored') : __('None') }}</span>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('{{ __('Delete this product?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-500">{{ __('Delete') }}</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-zinc-500 dark:text-zinc-300">
                        {{ __('No products yet. Create one to populate this list.') }}
                    </div>
                @endforelse
            </div>
        </div>

        {{ $products->links() }}
    </div>
</x-layouts.app>
