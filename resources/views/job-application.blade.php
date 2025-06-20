<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Recruitment Form</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
        <!-- Header -->
        <header class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Reveille Technologies Job Application</h1>
            <p class="text-gray-600">Join our team! Please fill out the form below.</p>
        </header>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Step <span id="currentStep">{{ session('current_step', 1) }}</span> of 5</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: {{ (session('current_step', 1) / 5) * 100 }}%"></div>
            </div>
        </div>

        <!-- Form -->
        <form id="jobForm" action="{{ route('job-application.store-step', ['step' => session('current_step', 1)]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-job-application.step-1-personal-info :formData="$formData" />
            <x-job-application.step-2-address :formData="$formData" />
            <x-job-application.step-3-position-details :formData="$formData" />
            <x-job-application.step-4-education-experience :formData="$formData" />
            <x-job-application.step-5-additional-info :formData="$formData" />

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-6">
                <button type="button" id="prevBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 {{ session('current_step', 1) == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ session('current_step', 1) == 1 ? 'disabled' : '' }}>Previous</button>
                <button type="button" id="nextBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 {{ session('current_step', 1) == 5 ? 'hidden' : '' }}">Next</button>
                <button type="submit" id="submitBtn" formaction="{{ route('job-application.submit') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 {{ session('current_step', 1) != 5 ? 'hidden' : '' }}">Submit</button>
            </div>
            <div class="flex justify-between mt-2">
                <form action="{{ route('job-application.save-draft') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:underline">Save as Draft</button>
                </form>
                <form action="{{ route('job-application.reset') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Reset Form</button>
                </form>
            </div>
        </form>

        <!-- Footer -->
        <footer class="text-center mt-6 text-gray-600">
            <p>© 2025 Acme Corp. All rights reserved.</p>
            <p>Contact: <a href="mailto:careers@acmecorp.com" class="text-blue-600 hover:underline">careers@acmecorp.com</a></p>
        </footer>
    </div>

    <script>
        let currentStep = {{ session('current_step', 1) }};
        const totalSteps = 5;
        const steps = document.querySelectorAll('.step');
        const progressBar = document.getElementById('progressBar');
        const currentStepDisplay = document.getElementById('currentStep');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('jobForm');

        function updateStep() {
            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index + 1 !== currentStep);
            });
            progressBar.style.width = `${(currentStep / totalSteps) * 100}%`;
            currentStepDisplay.textContent = currentStep;
            prevBtn.disabled = currentStep === 1;
            nextBtn.classList.toggle('hidden', currentStep === totalSteps);
            submitBtn.classList.toggle('hidden', currentStep !== totalSteps);
            // The form action is set on page load based on the current step.
            // We rely on the 'formaction' attribute for the final submit button.
        }

        // Explicitly submit the form when the Next button is clicked
        nextBtn.addEventListener('click', () => {
            form.submit();
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                // Update the form action to go to the previous step's processing URL
                // This is not strictly necessary if you handle step decrement via a GET request
                // but good for consistency if you were to POST to a 'previous' endpoint.
                // For now, we'll use a GET request to show the previous step.
                window.location.href = "{{ route('job-application.show') }}?step=" + currentStep;
            }
        });

        // Dynamic Fields
        let educationCount = {{ count(old('education', $formData['education'] ?? [[]])) }};
        const educationContainer = document.getElementById('step-4').querySelector('#educationContainer');
        document.getElementById('step-4').querySelector('#addEducation').addEventListener('click', () => {
            educationCount++;
            const entry = document.createElement('div');
            entry.className = 'education-entry mb-4 border p-4 rounded-md';
            entry.innerHTML = `
                <h3 class="text-lg font-medium text-gray-700">Education ${educationCount}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-y-2">
                        <label for="education[${educationCount - 1}][degree]" class="block text-sm font-medium text-gray-700">Degree/Qualification</label>
                        <input type="text" name="education[${educationCount - 1}][degree]" id="education[${educationCount - 1}][degree]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="education[${educationCount - 1}][institution]" class="block text-sm font-medium text-gray-700">Institution Name</label>
                        <input type="text" name="education[${educationCount - 1}][institution]" id="education[${educationCount - 1}][institution]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="education[${educationCount - 1}][year_passing]" class="block text-sm font-medium text-gray-700">Year of Passing</label>
                        <input type="number" name="education[${educationCount - 1}][year_passing]" id="education[${educationCount - 1}][year_passing]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="education[${educationCount - 1}][gpa]" class="block text-sm font-medium text-gray-700">Percentage/GPA</label>
                        <input type="text" name="education[${educationCount - 1}][gpa]" id="education[${educationCount - 1}][gpa]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                </div>
            `;
            educationContainer.appendChild(entry);
        });

        let experienceCount = {{ count(old('experience', $formData['experience'] ?? [[]])) }};
        const experienceContainer = document.getElementById('step-4').querySelector('#experienceContainer');
        document.getElementById('step-4').querySelector('#addExperience').addEventListener('click', () => {
            experienceCount++;
            const entry = document.createElement('div');
            entry.className = 'experience-entry mb-4 border p-4 rounded-md';
            entry.innerHTML = `
                <h3 class="text-lg font-medium text-gray-700">Experience ${experienceCount}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-y-2">
                        <label for="experience[${experienceCount - 1}][company]" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="experience[${experienceCount - 1}][company]" id="experience[${experienceCount - 1}][company]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="experience[${experienceCount - 1}][job_title]" class="block text-sm font-medium text-gray-700">Job Title/Position</label>
                        <input type="text" name="experience[${experienceCount - 1}][job_title]" id="experience[${experienceCount - 1}][job_title]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="experience[${experienceCount - 1}][duration_start]" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="experience[${experienceCount - 1}][duration_start]" id="experience[${experienceCount - 1}][duration_start]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm" required>
                    </div>
                    <div class="experience-end-date-field flex flex-col gap-y-2">
                        <label for="experience[${experienceCount - 1}][duration_end]" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="experience[${experienceCount - 1}][duration_end]" id="experience[${experienceCount - 1}][duration_end]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                    <div class="flex flex-col gap-y-2 justify-end"> {/* Adjusted for alignment with checkbox */}
                        <label class="flex items-center">
                            <input type="checkbox" name="experience[${experienceCount - 1}][currently_working]" value="1" class="currently-working-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Currently working here</span>
                        </label>
                    </div>
                    <div class="md:col-span-2">
                        <label for="experience[${experienceCount - 1}][responsibilities]" class="block text-sm font-medium text-gray-700">Responsibilities/Key Projects</label>
                        <textarea name="experience[${experienceCount - 1}][responsibilities]" id="experience[${experienceCount - 1}][responsibilities]" class="border-input focus-visible:ring-ring flex w-full rounded-md h-32 border px-3 py-3 md:text-sm" required></textarea>
                    </div>
                </div>
            `;
            experienceContainer.appendChild(entry);
            // Initialize and add event listener for the new checkbox
            const newCheckbox = entry.querySelector('.currently-working-checkbox');
            if (newCheckbox) {
                newCheckbox.addEventListener('change', () => {
                    toggleEndDateVisibility(entry);
                });
                toggleEndDateVisibility(entry); // Set initial state for the new entry
            }
        });

        let certificationCount = {{ count(old('certifications', $formData['certifications'] ?? [[]])) }};
        const certificationContainer = document.getElementById('step-5').querySelector('#certificationContainer');
        document.getElementById('step-5').querySelector('#addCertification').addEventListener('click', () => {
            certificationCount++;
            const container = document.getElementById('certificationContainer'); // Ensure this is the correct container ID from step-5
            const entry = document.createElement('div');
            entry.className = 'certification-entry mb-4 border p-4 rounded-md';
            entry.innerHTML = `
                <h3 class="text-lg font-medium text-gray-700">Certification ${certificationCount}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-y-2">
                        <label for="certifications[${certificationCount - 1}][name]" class="block text-sm font-medium text-gray-700">Certification Name</label>
                        <input type="text" name="certifications[${certificationCount - 1}][name]" id="certifications[${certificationCount - 1}][name]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="certifications[${certificationCount - 1}][authority]" class="block text-sm font-medium text-gray-700">Issuing Authority</label>
                        <input type="text" name="certifications[${certificationCount - 1}][authority]" id="certifications[${certificationCount - 1}][authority]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="certifications[${certificationCount - 1}][year]" class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="number" name="certifications[${certificationCount - 1}][year]" id="certifications[${certificationCount - 1}][year]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                </div>
            `;
            container.appendChild(entry);
        });

        let referenceCount = {{ count(old('references', $formData['references'] ?? [[]])) }};
        const referenceContainer = document.getElementById('step-5').querySelector('#referenceContainer');
        document.getElementById('step-5').querySelector('#addReference').addEventListener('click', () => {
            referenceCount++;
            const entry = document.createElement('div');
            entry.className = 'reference-entry mb-4 border p-4 rounded-md';
            entry.innerHTML = `
                <h3 class="text-lg font-medium text-gray-700">Reference ${referenceCount}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-y-2">
                        <label for="references[${referenceCount - 1}][name]" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="references[${referenceCount - 1}][name]" id="references[${referenceCount - 1}][name]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="references[${referenceCount - 1}][contact]" class="block text-sm font-medium text-gray-700">Contact</label>
                        <input type="text" name="references[${referenceCount - 1}][contact]" id="references[${referenceCount - 1}][contact]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="references[${referenceCount - 1}][relationship]" class="block text-sm font-medium text-gray-700">Relationship</label>
                        <input type="text" name="references[${referenceCount - 1}][relationship]" id="references[${referenceCount - 1}][relationship]" class="border-input focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 md:text-sm">
                    </div>
                </div>
            `;
            referenceContainer.appendChild(entry);
        });

        // Function to toggle end date visibility
        function toggleEndDateVisibility(experienceEntry) {
            const checkbox = experienceEntry.querySelector('.currently-working-checkbox');
            const endDateField = experienceEntry.querySelector('.experience-end-date-field');
            if (checkbox && endDateField) {
                endDateField.classList.toggle('hidden', checkbox.checked);
                // Also clear the end date value if hidden and make it not required
                const endDateInput = endDateField.querySelector('input[type="date"]');
                if (endDateInput) {
                    if (checkbox.checked) {
                        endDateInput.value = '';
                        endDateInput.required = false;
                    } else {
                        // If you want to make it required when visible, uncomment the next line
                        // endDateInput.required = true;
                    }
                }
            }
        }

        // Initialize end date visibility for existing entries and attach event listeners
        document.querySelectorAll('.experience-entry').forEach(experienceEntry => {
            toggleEndDateVisibility(experienceEntry); // Set initial state
            const checkbox = experienceEntry.querySelector('.currently-working-checkbox');
            if (checkbox) {
                checkbox.addEventListener('change', () => {
                    toggleEndDateVisibility(experienceEntry);
                });
            }
        });

        updateStep();
    </script>
</body>
</html>
