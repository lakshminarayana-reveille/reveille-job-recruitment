@props(['formData'])

<div id="step-5" class="step {{ session('current_step', 1) == 5 ? '' : 'hidden' }}">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Skills, Documents & Declarations</h2>
    <!-- Skills -->
    <div class="mb-4">
        <x-form-input label="Key Skills (comma-separated)" name="skills" id="skills" type="text" :value="old('skills', $formData['skills'] ?? '')"  />
    </div>
    <!-- Certifications -->
    {{-- <div id="certificationContainer" class="mb-4">
        @php
            $certifications = old('certifications', $formData['certifications'] ?? [[]]);
        @endphp
        @foreach ($certifications as $index => $certification)
            <div class="certification-entry border p-4 rounded-md mb-2">
                <h3 class="text-lg font-medium text-gray-700">Certification {{ $index + 1 }} (Optional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input label="Certification Name" name="certifications[{{ $index }}][name]" :value="old('certifications.'.$index.'.name', $certification['name'] ?? '')" />
                    <x-form-input label="Issuing Authority" name="certifications[{{ $index }}][authority]" :value="old('certifications.'.$index.'.authority', $certification['authority'] ?? '')" />
                    <x-form-input label="Year" name="certifications[{{ $index }}][year]" type="number" :value="old('certifications.'.$index.'.year', $certification['year'] ?? '')" />
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" id="addCertification" class="text-blue-600 hover:underline mb-4">+ Add Another Certification</button> --}}

    <!-- Documents -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <x-form-input label="Resume (PDF/DOC)" name="resume" id="resume" type="file" accept=".pdf,.doc,.docx"  />
        <x-form-input label="Cover Letter (Optional)" name="cover_letter" id="cover_letter" type="file" accept=".pdf,.doc,.docx" />
        {{-- <x-form-input label="Portfolio (Optional)" name="portfolio" id="portfolio" type="file" />
        <x-form-input label="Certificates (Optional)" name="certificates[]" id="certificates" type="file" accept=".pdf" multiple /> --}}
        <x-form-input label="Photo" name="photo" id="photo" type="file" accept="image/*"  />
    </div>

    <!-- Additional Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Willing to relocate?</label>
            <div class="mt-1 flex space-x-4">
                <label><input type="radio" name="relocate" value="yes" {{ old('relocate', $formData['relocate'] ?? '') == 'yes' ? 'checked' : '' }}> Yes</label>
                <label><input type="radio" name="relocate" value="no" {{ old('relocate', $formData['relocate'] ?? '') == 'no' ? 'checked' : '' }}> No</label>
            </div>
            @error('relocate')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Legally eligible to work in this country?</label>
            <div class="mt-1 flex space-x-4">
                <label><input type="radio" name="eligible" value="yes" {{ old('eligible', $formData['eligible'] ?? '') == 'yes' ? 'checked' : '' }}> Yes</label>
                <label><input type="radio" name="eligible" value="no" {{ old('eligible', $formData['eligible'] ?? '') == 'no' ? 'checked' : '' }}> No</label>
            </div>
            @error('eligible')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <x-form-input label="Notice Period (days)" name="notice_period" id="notice_period" type="number" :value="old('notice_period', $formData['notice_period'] ?? '')" />
    </div>
    <!-- References -->
    <div class="reference-entry border p-4 rounded-md mb-4">
        <h3 class="text-lg font-medium text-gray-700">Reference (Optional)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-form-input label="Name" name="references_name" :value="old('references_name', $formData['references_name'] ?? '')" />
            <x-form-input label="Contact" name="references_contact]" :value="old('references_contact', $formData['references_contact'] ?? '')" />
            <x-form-input label="Relationship" name="references_relationship]" :value="old('references_relationship', $formData['references_relationship'] ?? '')" />
        </div>
    </div>
    <div>
        <x-form-input label="Additional Comments" name="comments" id="comments" type="textarea">{{ old('comments', $formData['comments'] ?? '') }}</x-form-input>
    </div>

    <!-- Declarations -->
    <div class="mt-4 space-y-4">
        <label class="flex items-center">
            <input type="checkbox" name="declaration" value="1" {{ old('declaration', $formData['declaration'] ?? '') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('declaration') border-red-500 @enderror">
            <span class="ml-2 text-sm text-gray-700">I hereby declare that the above information is true to the best of my knowledge.</span>
        </label>
        @error('declaration')
            <p class="text-red-500 text-xs ml-6">{{ $message }}</p> {{-- Adjusted margin for alignment --}}
        @enderror
        <label class="flex items-center">
            <input type="checkbox" name="consent" value="1" {{ old('consent', $formData['consent'] ?? '') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 @error('consent') border-red-500 @enderror">
            <span class="ml-2 text-sm text-gray-700">I agree to the terms and privacy policy.</span>
        </label>
        @error('consent')
            <p class="text-red-500 text-xs ml-6">{{ $message }}</p> {{-- Adjusted margin for alignment --}}
        @enderror
    </div>
</div>
