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
            <table class="min-w-full divide-y divide-zinc-100 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-300">
                        <th class="px-5 py-3 text-left lg:w-2/5">{{ __('Product') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Price') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Stock') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Image') }}</th>
                        <th class="px-5 py-3 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700 text-sm text-zinc-700 dark:text-white">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($product->image_url)
                                        <span class="h-10 w-10 overflow-hidden rounded-xl bg-zinc-100">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                        </span>
                                    @else
                                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-200 text-xs text-zinc-500">{{ Str::substr($product->name, 0, 2) }}</span>
                                    @endif
                                    <div>
                                        <p class="font-semibold">{{ $product->name }}</p>
                                        <p class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ $product->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ number_format($product->price, 2) }}</td>
                            <td class="px-5 py-4">{{ number_format($product->stock) }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col items-center gap-2 text-center text-xs uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                                    <span>{{ __('Image') }}</span>
                                    @if($product->image_url)
                                        <span class="h-16 w-16 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                        </span>
                                    @else
                                        <span class="flex h-16 w-16 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-50 text-[10px] font-semibold text-zinc-500 dark:border-zinc-700">{{ __('No image') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('{{ __('Delete this product?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-500">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-zinc-500 dark:text-zinc-300">
                                {{ __('No products yet. Create one to populate this list.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>
</x-layouts.app>
