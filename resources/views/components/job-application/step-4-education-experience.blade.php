@props(['formData'])

<div id="step-4" class="step {{ session('current_step', 1) == 4 ? '' : 'hidden' }}">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Education & Experience</h2>
    <!-- Education -->
    <div id="educationContainer">
        @php
            $educations = old('education', $formData['education'] ?? [[]]);
        @endphp
        @foreach ($educations as $index => $education)
            <div class="education-entry mb-4 border p-4 rounded-md">
                <h3 class="text-lg font-medium text-gray-700">Education {{ $index + 1 }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input label="Degree/Qualification" name="education[{{ $index }}][degree]" :value="old('education.'.$index.'.degree', $education['degree'] ?? '')" required />
                    <x-form-input label="Institution Name" name="education[{{ $index }}][institution]" :value="old('education.'.$index.'.institution', $education['institution'] ?? '')" required />
                    <x-form-input label="Year of Passing" name="education[{{ $index }}][year_passing]" type="number" :value="old('education.'.$index.'.year_passing', $education['year_passing'] ?? '')" required />
                    <x-form-input label="Percentage/GPA" name="education[{{ $index }}][gpa]" :value="old('education.'.$index.'.gpa', $education['gpa'] ?? '')" required />
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" id="addEducation" class="text-blue-600 hover:underline">+ Add Another Education</button>

    <!-- Work Experience -->
    <div id="experienceContainer" class="mt-6">
        @php
            $experiences = old('experience', $formData['experience'] ?? [[]]);
        @endphp
        @foreach ($experiences as $index => $experience)
            <div class="experience-entry mb-4 border p-4 rounded-md">
                <h3 class="text-lg font-medium text-gray-700">Experience {{ $index + 1 }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input label="Company Name" name="experience[{{ $index }}][company]" :value="old('experience.'.$index.'.company', $experience['company'] ?? '')" required />
                    <x-form-input label="Job Title/Position" name="experience[{{ $index }}][job_title]" :value="old('experience.'.$index.'.job_title', $experience['job_title'] ?? '')" required />
                    <x-form-date label="Start Date" name="experience[{{ $index }}][duration_start]" :value="old('experience.'.$index.'.duration_start', $experience['duration_start'] ?? '')" required />
                    <div class="experience-end-date-field">
                        <x-form-date label="End Date" name="experience[{{ $index }}][duration_end]" :value="old('experience.'.$index.'.duration_end', $experience['duration_end'] ?? '')" />
                    </div>
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="experience[{{ $index }}][currently_working]" value="1" class="currently-working-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('experience.'.$index.'.currently_working', $experience['currently_working'] ?? '') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Currently working here</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <x-form-input label="Responsibilities/Key Projects" name="experience[{{ $index }}][responsibilities]" type="textarea" required>{{ old('experience.'.$index.'.responsibilities', $experience['responsibilities'] ?? '') }}</x-form-input>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" id="addExperience" class="text-blue-600 hover:underline">+ Add Another Experience</button>
</div>
