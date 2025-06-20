@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'id' => null, 'value' => null, 'options' => [], 'checkedValue' => null])
{{-- The 'value' prop was added to allow pre-filling input fields, common for edit forms or when repopulating from old input/session data --}}
{{-- Main container for the input field and its label --}}
<div class="flex flex-col gap-y-2">
    {{-- Label for the input field --}}
    <label class="block text-sm font-medium text-gray-700 @error($name) text-red-500 @enderror"
        for="{{ $id ?? $name }}">{{ $label }}</label>

    {{-- Textarea input type --}}
    @if ($type === 'textarea')
        <textarea id="{{ $id ?? $name }}" name="{{ $name }}"
            class="border-input focus-visible:ring-ring flex w-full rounded-md h-32 border px-3 py-3 md:text-sm @error($name) border-red-500 @enderror"
            placeholder="{{ $placeholder }}"
            {{ $attributes }}>{{ $value ?? $slot }}</textarea>

    {{-- File input type --}}
    @elseif($type === 'file')
        <div class="file-upload-container flex items-center justify-center w-full border-2 border-dashed border-gray-400 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
            {{-- Label styled as dropzone --}}
            <label for="{{ $id ?? $name }}"
                class="flex flex-col items-center justify-center w-full h-24 cursor-pointer">
                <div class="flex flex-col items-center justify-center">
                    <p class="file-upload-main-text mb-2 text-sm text-gray-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="file-upload-formats-text text-xs text-gray-500">Supported formats: PDF, DOCX, Images (Max 10MB)</p>
                </div>
                {{-- Actual file input --}}
                <input id="{{ $id ?? $name }}" type="file" class="hidden" name="{{ $name }}" {{ $attributes }}>
            </label>
        </div>

    {{-- Select input type --}}
    @elseif($type === 'select')
        <select id="{{ $id ?? $name }}" name="{{ $name }}"
            class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm @error($name) border-red-500 @enderror"
            {{ $attributes }}>
            @if (!empty($placeholder))
                <option value="" disabled {{ ($value ?? '') == '' ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif
            @foreach ($options ?? [] as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ ($value ?? '') == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}</option>
            @endforeach
        </select>

    @else
        <input type="{{ $type }}"
            class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm @error($name) border-red-500 @enderror"
            placeholder="{{ $placeholder }}" id="{{ $id ?? $name }}" name="{{ $name }}"
            value="{{ $value ?? '' }}"
            {{ $attributes }}>
    @endif

    {{-- Display validation error messages --}}
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
