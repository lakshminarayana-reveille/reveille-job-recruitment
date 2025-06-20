@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'id' => null])
{{-- block w-full border-input rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 --}}
<div class="flex flex-col gap-y-2">
    <label class="block text-sm font-medium text-gray-700 @error($name) text-red-500 @enderror" for="{{ $id ?? $name }}">{{ $label }}</label>
    @if($type === 'textarea')
        <textarea
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="border-input focus-visible:ring-ring flex w-full rounded-md h-32 border px-3 py-3 md:text-sm @error($name) border-red-500 @enderror"
            {{ $attributes }}
        >{{ $slot }}</textarea>
    @else
        <input
            type="{{ $type }}"
            class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm @error($name) border-red-500 @enderror"
            placeholder="{{ $placeholder }}"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            {{ $attributes }}
        >
    @endif
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
