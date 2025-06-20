@props(['label', 'name', 'id' => null])

<div class="flex flex-col gap-y-2">
    <label for="{{ $id ?? $name }}" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 @error($name) text-red-500 @enderror">{{ $label }}</label>
    <div class="flex flex-row-reverse items-center border-input rounded-md border shadow-xs @error($name) border-red-500 @enderror">
        <input
            type="date"
            class="flex-grow h-9 w-full bg-transparent px-3 py-4 text-base transition-colors focus-visible:ring-1 focus-visible:outline-hidden disabled:cursor-not-allowed disabled:opacity-50 md:text-sm @error($name) border-red-500 @enderror"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            {{ $attributes }}
        >
    </div>
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
