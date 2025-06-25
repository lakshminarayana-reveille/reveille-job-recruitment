@props(['label', 'name', 'value', 'options', 'id' => null])

<div class="flex flex-col gap-y-2">
    <label for="{{ $id ?? $name }}" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 @error($name) text-red-500 @enderror">{{ $label }}</label>
    <select
        class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border pl-3 pr-5 md:text-sm @error($name) border-red-500 @enderror"
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        {{ $attributes }}
    >
        @foreach($options as $optionValue => $optionText)
            <option value="{{ $optionValue }}" @if($optionValue == old($name, $value)) selected @endif>{{ $optionText }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
{{-- border-input file:text-foreground placeholder:text-muted-foreground focus-visible:ring-ring flex h-9 w-full rounded-md border bg-transparent px-3 py-4 text-base shadow-xs transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:ring-1 focus-visible:outline-hidden disabled:cursor-not-allowed disabled:opacity-50 md:text-sm --}}
