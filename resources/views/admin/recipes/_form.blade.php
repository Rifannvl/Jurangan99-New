<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="flex flex-col text-sm font-semibold text-zinc-700">
            <span>{{ __('Title') }}</span>
            <input
                type="text"
                name="title"
                value="{{ old('title', $recipe->title) }}"
                class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
            />
            @error('title')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </label>
        <label class="flex flex-col text-sm font-semibold text-zinc-700">
            <span>{{ __('Slug') }}</span>
            <input
                type="text"
                name="slug"
                value="{{ old('slug', $recipe->slug) }}"
                class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
            />
            @error('slug')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </label>
    </div>

    <label class="flex flex-col text-sm font-semibold text-zinc-700">
        <span>{{ __('Excerpt') }}</span>
        <input
            type="text"
            name="excerpt"
            value="{{ old('excerpt', $recipe->excerpt) }}"
            class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
        />
        @error('excerpt')
            <p class="text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </label>

    <label class="flex flex-col text-sm font-semibold text-zinc-700">
        <span>{{ __('Body') }}</span>
        <textarea
            name="body"
            rows="6"
            class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
        >{{ old('body', $recipe->body) }}</textarea>
        @error('body')
            <p class="text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </label>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="flex flex-col text-sm font-semibold text-zinc-700">
            <span>{{ __('Product link') }}</span>
            <input
                type="url"
                name="product_link"
                value="{{ old('product_link', $recipe->product_link) }}"
                class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
            />
            @error('product_link')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </label>
        <label class="flex flex-col text-sm font-semibold text-zinc-700">
            <span>{{ __('Product link text') }}</span>
            <input
                type="text"
                name="product_link_text"
                value="{{ old('product_link_text', $recipe->product_link_text ?? __('Beli sekarang')) }}"
                class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
            />
            @error('product_link_text')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </label>
    </div>

    <label class="flex flex-col text-sm font-semibold text-zinc-700">
        <span>{{ __('Published at') }}</span>
        <input
            type="datetime-local"
            name="published_at"
            value="{{ old('published_at', optional($recipe->published_at)->format('Y-m-d\TH:i')) }}"
            class="mt-2 rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none"
        />
        @error('published_at')
            <p class="text-xs text-rose-600">{{ $message }}</p>
        @enderror
    </label>
</div>
