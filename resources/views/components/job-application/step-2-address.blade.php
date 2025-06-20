@props(['formData'])

<div id="step-2" class="step {{ session('current_step', 1) == 2 ? '' : 'hidden' }}">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Address</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <x-form-input label="Current Address" name="current_address" id="current_address" type="textarea" required>{{ old('current_address', $formData['current_address'] ?? '') }}</x-form-input>
        </div>
        <div class="md:col-span-2">
            <x-form-input label="Permanent Address (if different)" name="permanent_address" id="permanent_address" type="textarea">{{ old('permanent_address', $formData['permanent_address'] ?? '') }}</x-form-input>
        </div>
        <x-form-input label="City" name="city" id="city" type="text" :value="old('city', $formData['city'] ?? '')" required />
        <x-form-input label="State/Province" name="state" id="state" type="text" :value="old('state', $formData['state'] ?? '')" required />
        <x-form-input label="ZIP/Postal Code" name="zip" id="zip" type="text" :value="old('zip', $formData['zip'] ?? '')" required />
        <x-form-input label="Country" name="country" id="country" type="text" :value="old('country', $formData['country'] ?? '')" required />
    </div>
</div>
