@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="__('Orders')">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900">{{ __('Orders') }}</h1>
                <p class="text-sm text-zinc-500">{{ __('Pantau checkout terbaru dan status tiap pesanan.') }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white/90 shadow-sm">
            <table class="min-w-full divide-y divide-zinc-100 text-sm text-zinc-700">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                    <tr>
                        <th class="px-5 py-3 text-left">{{ __('Order') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Customer') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Total') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Items') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Status') }}</th>
                        <th class="px-5 py-3 text-left">{{ __('Created') }}</th>
                        <th class="px-5 py-3 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 bg-white">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-5 py-4 font-semibold text-zinc-900">#{{ $order->id }}</td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-zinc-900">{{ $order->customer_name }}</div>
                                <div class="text-xs text-zinc-500">{{ $order->customer_email }}</div>
                            </td>
                            <td class="px-5 py-4">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">{{ $order->items_count }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-700 bg-emerald-50">{{ Str::upper($order->status) }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs text-zinc-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">{{ __('View') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-zinc-500">{{ __('Belum ada pesanan.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </div>
</x-layouts.app>
