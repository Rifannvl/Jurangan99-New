<x-layouts.app :title="__('Edit product')">
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Edit product') }}</h1>
            <p class="text-sm text-zinc-500">{{ __('Update the details and image for this product.') }}</p>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.products._form')
            <div class="flex justify-between">
                <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-zinc-500">{{ __('Cancel') }}</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600">
                    {{ __('Update product') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
