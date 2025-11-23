<x-layouts.app :title="__('Resep')">
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Resep masakan') }}</h1>
                <p class="text-sm text-zinc-500">{{ __('Kelola artikel resep dan tautan produk terkait.') }}</p>
            </div>
            <a
                href="{{ route('admin.recipes.create') }}"
                class="inline-flex items-center justify-center rounded-2xl border border-emerald-500 bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600"
            >{{ __('Tambah resep') }}</a>
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
                        <th class="px-5 py-3 text-left w-1/3">{{ __('Judul') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Dipublikasikan') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Tautan produk') }}</th>
                        <th class="px-5 py-3 text-right">{{ __('Tindakan') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700 text-sm text-zinc-700 dark:text-white">
                    @forelse($recipes as $recipe)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-zinc-900 dark:text-white">{{ $recipe->title }}</div>
                                <div class="text-xs text-zinc-500">{{ $recipe->slug }}</div>
                            </td>
                            <td class="px-5 py-4">{{ $recipe->published_at?->toDayDateTimeString() ?? __('Belum dipublikasikan') }}</td>
                            <td class="px-5 py-4">
                                @if($recipe->product_link)
                                    <a href="{{ $recipe->product_link }}" class="text-emerald-600 hover:text-emerald-500" target="_blank" rel="noreferrer">{{ $recipe->product_link_text }}</a>
                                @else
                                    <span class="text-xs text-zinc-400">{{ __('Tidak ada tautan') }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.recipes.edit', $recipe) }}"
                                        class="text-sm font-semibold text-emerald-600 hover:text-emerald-500"
                                    >{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('{{ __('Hapus resep ini?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-500">{{ __('Hapus') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-zinc-500 dark:text-zinc-300">
                                {{ __('Belum ada resep. Tambahkan resep baru untuk mulai membuat konten.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $recipes->links() }}
    </div>
</x-layouts.app>
