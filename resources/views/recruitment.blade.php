<!DOCTYPE html>
<html>

<head>
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
        @if ($errors->any() && session('current_step', 1) === 7)
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
                <span class="text-sm font-medium text-gray-700">Step <span id="currentStep">{{ session('current_step', 1) }}</span> of 7</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: {{ (session('current_step', 1) / 7) * 100 }}%"></div>
            </div>
        </div>

        <!-- Form -->
        <form id="jobForm" action="{{ route('recruitment.store-step', ['step' => session('current_step', 1)]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Step 1: Basic Info -->
            <div id="step-1" class="step {{ session('current_step', 1) != 1 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <x-form-input label="Name" name="name" id="name" type="text" :value="old('name', $formData['name'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-input label="Email Address" name="email" id="email" type="email" :value="old('email', $formData['email'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-input label="Contact Number" name="contact_number" id="contact_number" type="tel" :value="old('contact_number', $formData['contact_number'] ?? '')" required />
                    </div>
                </div>
            </div>

            <!-- Step 2: Personal Information -->
            <div id="step-2" class="step {{ session('current_step', 1) != 2 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <x-form-input label="Position Applied For" name="position_applied" id="position_applied" type="text" :value="old('position_applied', $formData['position_applied'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-date label="Date of Birth (DD/MM/YYYY)" name="dob" id="dob" :value="old('dob', $formData['dob'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-select label="Gender" name="gender" id="gender" :value="old('gender', $formData['gender'] ?? '')" :options="['' => 'Select', 'male' => 'Male', 'female' => 'Female', 'other' => 'Other']" required />
                    </div>
                    <div>
                        <x-form-input label="Blood Group" name="blood_group" id="blood_group" type="text" :value="old('blood_group', $formData['blood_group'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-select label="Marital Status" name="marital_status" id="marital_status" :value="old('marital_status', $formData['marital_status'] ?? '')" :options="['' => 'Select', 'married' => 'Married', 'single' => 'Single', 'divorced' => 'Divorced', 'widowed' => 'Widowed']" required />
                    </div>
                    <div>
                        <x-form-input label="Nationality" name="nationality" id="nationality" type="text" :value="old('nationality', $formData['nationality'] ?? '')" required />
                    </div>
                </div>
            </div>

            <!-- Step 3: Address Details -->
            <div id="step-3" class="step {{ session('current_step', 1) != 3 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Address Details</h2>
                <div class="space-y-4">
                    <div>
                        <x-form-input label="Present Address" name="present_address" id="present_address" type="textarea" required>{{ old('present_address', $formData['present_address'] ?? '') }}</x-form-input>
                    </div>
                    <div>
                        <x-form-input label="Permanent Address (if different from Present Address)" name="permanent_address" id="permanent_address" type="textarea" required>{{ old('permanent_address', $formData['permanent_address'] ?? '') }}</x-form-input>
                    </div>
                </div>
            </div>

            <!-- Step 4: Educational & Professional Details -->
            <div id="step-4" class="step {{ session('current_step', 1) != 4 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Educational & Professional Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-form-input label="Highest Educational Qualification" name="education_qualification" id="education_qualification" type="text" :value="old('education_qualification', $formData['education_qualification'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-input label="Total Work Experience (in years)" name="total_experience" id="total_experience" type="number" :value="old('total_experience', $formData['total_experience'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-input label="Relevant Experience (in years)" name="relevant_experience" id="relevant_experience" type="number" :value="old('relevant_experience', $formData['relevant_experience'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-input label="Current CTC (LPA)" name="current_ctc" id="current_ctc" type="text" :value="old('current_ctc', $formData['current_ctc'] ?? '')" required />
                    </div>
                    <div>
                        <x-form-input label="Expected CTC (LPA)" name="expected_ctc" id="expected_ctc" type="number" :value="old('expected_ctc', $formData['expected_ctc'] ?? '')" required />
                    </div>
                </div>
            </div>

            <!-- Step 5: Previous Company Interaction -->
            <div id="step-5" class="step {{ session('current_step', 1) != 5 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Company Interaction</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Have you ever applied/worked for this company before?</label>
                        <div class="mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="applied_before" value="yes" class="form-radio" {{ old('applied_before', $formData['applied_before'] ?? '') == 'yes' ? 'checked' : '' }}>
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="applied_before" value="no" class="form-radio" {{ old('applied_before', $formData['applied_before'] ?? 'no') == 'no' ? 'checked' : '' }}>
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>
                    <div id="applied_before_details_container" class="{{ old('applied_before', $formData['applied_before'] ?? 'no') == 'yes' ? '' : 'hidden' }}">
                        <x-form-input label="If yes, please explain" name="applied_before_details" id="applied_before_details" type="textarea" required>{{ old('applied_before_details', $formData['applied_before_details'] ?? '') }}</x-form-input>
                        {{-- <label for="applied_before_details" class="block text-sm font-medium text-gray-700">If yes, please explain</label>
                        <textarea name="applied_before_details" id="applied_before_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('applied_before_details', $formData['applied_before_details'] ?? '') }}</textarea> --}}
                    </div>
                </div>
            </div>

            <!-- Step 6: Existing Employee Connections -->
            <div id="step-6" class="step {{ session('current_step', 1) != 6 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Existing Employee Connections</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Do you have any friends, relatives or acquaintances working for this company?</label>
                        <div class="mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="has_relatives" value="yes" class="form-radio" {{ old('has_relatives', $formData['has_relatives'] ?? '') == 'yes' ? 'checked' : '' }}>
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="has_relatives" value="no" class="form-radio" {{ old('has_relatives', $formData['has_relatives'] ?? 'no') == 'no' ? 'checked' : '' }}>
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>
                    <div id="relatives_details_container" class="{{ old('has_relatives', $formData['has_relatives'] ?? 'no') == 'yes' ? '' : 'hidden' }}">
                        <x-form-input label="If yes, state Name & Position" name="relatives_details" id="relatives_details" type="textarea" required>{{ old('relatives_details', $formData['relatives_details'] ?? '') }}</x-form-input>
                        {{-- <label for="relatives_details" class="block text-sm font-medium text-gray-700">If yes, state Name & Position</label> --}}
                        {{-- <textarea name="relatives_details" id="relatives_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('relatives_details', $formData['relatives_details'] ?? '') }}</textarea> --}}
                    </div>
                </div>
            </div>

            <!-- Step 7: References -->
            <div id="step-7" class="step {{ session('current_step', 1) != 7 ? 'hidden' : '' }}">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">References & Documents</h2>
                <!-- Documents -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <x-form-input label="Resume (PDF only)" name="resume" id="resume" type="file" accept=".pdf" required />
                    <x-form-input label="Photo (Optional)" name="photo" id="photo" description="Supported formats: JPG, PNG Only (Max 300kB)" type="file" accept="image/*" />
                </div>

                <div id="referencesContainer">
                    @php $references = old('references', $formData['references'] ?? [['name' => '', 'designation' => '', 'company' => '', 'mobile' => '']]); @endphp
                    @foreach ($references as $index => $reference)
                        <div class="reference-entry mb-4 border p-4 rounded-md relative">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Reference {{ $index + 1 }}</h3>
                            @if ($index > 0)
                                <button type="button" class="remove-reference absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white text-sm px-2 py-1 rounded">Remove</button>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-form-input label="Name" name="references[{{$index}}][name]" id="references_{{$index}}_name" type="text" :value="old('references.'.$index.'.name', $reference['name'] ?? '')" />
                                <x-form-input label="Designation" name="references[{{$index}}][designation]" id="references_{{$index}}_designation" type="text" :value="old('references.'.$index.'.designation', $reference['designation'] ?? '')" />
                                <x-form-input label="Company" name="references[{{$index}}][company]" id="references_{{$index}}_company" type="text" :value="old('references.'.$index.'.company', $reference['company'] ?? '')" />
                                <x-form-input label="Mobile No" name="references[{{$index}}][mobile]" id="references_{{$index}}_mobile" type="tel" :value="old('references.'.$index.'.mobile', $reference['mobile'] ?? '')" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addReference" class="text-blue-600 hover:underline">+ Add Another Reference</button>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-6">
                <button type="button" id="prevBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 {{ session('current_step', 1) == 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ session('current_step', 1) == 1 ? 'disabled' : '' }}>Previous</button>
                <button type="button" id="nextBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 {{ session('current_step', 1) == 7 ? 'hidden' : '' }}">Next</button>
                <button type="submit" id="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 {{ session('current_step', 1) != 7 ? 'hidden' : '' }}">Submit</button>
            </div>
        </form>
        <div class="flex justify-end mt-2">
            <form action="{{ route('recruitment.reset') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">Reset Form</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentStep = {{ session('current_step', 1) }};
            const totalSteps = 7;
            const steps = document.querySelectorAll('.step');
            const progressBar = document.getElementById('progressBar');
            const currentStepDisplay = document.getElementById('currentStep');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('jobForm');

            function updateStepVisibility() {
                steps.forEach((step, index) => {
                    step.classList.toggle('hidden', index + 1 !== currentStep);
                });
                if(progressBar) progressBar.style.width = `${(currentStep / totalSteps) * 100}%`;
                if(currentStepDisplay) currentStepDisplay.textContent = currentStep;

                if(prevBtn) {
                    prevBtn.disabled = currentStep === 1;
                    prevBtn.classList.toggle('opacity-50', currentStep === 1);
                    prevBtn.classList.toggle('cursor-not-allowed', currentStep === 1);
                }

                if(nextBtn) nextBtn.classList.toggle('hidden', currentStep === totalSteps);
                if(submitBtn) submitBtn.classList.toggle('hidden', currentStep !== totalSteps);
            }

            if(nextBtn) nextBtn.addEventListener('click', () => form.submit());

            if(prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentStep > 1) {
                        window.location.href = `{{ route('recruitment.show') }}?step=${currentStep - 1}`;
                    }
                });
            }

            if(submitBtn) {
                submitBtn.addEventListener('click', () => {
                    form.action = '{{ route("recruitment.submit") }}';
                    form.submit();
                });
            }

            // JS for conditional fields
            document.querySelectorAll('input[name="applied_before"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.getElementById('applied_before_details_container').classList.toggle('hidden', this.value !== 'yes');
                });
            });

            document.querySelectorAll('input[name="has_relatives"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.getElementById('relatives_details_container').classList.toggle('hidden', this.value !== 'yes');
                });
            });

            // JS for adding/removing references
            const addReferenceBtn = document.getElementById('addReference');
            const referencesContainer = document.getElementById('referencesContainer');
            // Initialize referenceCount based on existing elements or default to 1 if none
            let referenceCount = referencesContainer ? referencesContainer.querySelectorAll('.reference-entry').length : 0;
            if (referenceCount === 0) referenceCount = 1; // Ensure at least one reference is counted for indexing

            if(addReferenceBtn) {
                addReferenceBtn.addEventListener('click', () => {
                    const newIndex = referencesContainer.querySelectorAll('.reference-entry').length; // Use current count for new index
                    const entry = document.createElement('div');
                    entry.className = 'reference-entry mb-4 border p-4 rounded-md relative';
                    entry.innerHTML = `
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Reference ${newIndex + 1}</h3>
                        <button type="button" class="remove-reference absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white text-sm px-2 py-1 rounded">Remove</button>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-form-input label="Name" name="references_{{$index}}_name" id="references_{{$index}}_name" type="text" :value="old('references_{{$index}}_name', $formData['references_{{$index}}_name'] ?? '')" />
                                {{-- <label for="references_{{$index}}_name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="references[{{$index}}][name]" id="references_{{$index}}_name" value="{{ old('references.'.$index.'.name', $reference['name'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> --}}
                            </div>
                            <div>
                                <x-form-input label="Designation" name="references_{{$index}}_designation" id="references_{{$index}}_designation" type="text" :value="old('references_{{$index}}_designation', $formData['references_{{$index}}_designation'] ?? '')" />
                                {{-- <label for="references_{{$index}}_designation" class="block text-sm font-medium text-gray-700">Designation</label>
                                <input type="text" name="references[{{$index}}][designation]" id="references_{{$index}}_designation" value="{{ old('references.'.$index.'.designation', $reference['designation'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> --}}
                            </div>
                            <div>
                                <x-form-input label="Company" name="references_{{$index}}_company" id="references_{{$index}}_company" type="text" :value="old('references_{{$index}}_company', $formData['references_{{$index}}_company'] ?? '')" />
                                {{-- <label for="references_{{$index}}_company" class="block text-sm font-medium text-gray-700">Company</label>
                                <input type="text" name="references[{{$index}}][company]" id="references_{{$index}}_company" value="{{ old('references.'.$index.'.company', $reference['company'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> --}}
                            </div>
                            <div>
                                <x-form-input label="Mobile No" name="references_{{$index}}_mobile" id="references_{{$index}}_mobile" type="tel" :value="old('references_{{$index}}_mobile', $formData['references_{{$index}}_mobile'] ?? '')" />
                                {{-- <label for="references_{{$index}}_mobile" class="block text-sm font-medium text-gray-700">Mobile No</label>
                                <input type="text" name="references[{{$index}}][mobile]" id="references_{{$index}}_mobile" value="{{ old('references.'.$index.'.mobile', $reference['mobile'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> --}}
                            </div>
                        </div>
                    `;
                    referencesContainer.appendChild(entry);
                });
            }

            if(referencesContainer) {
                referencesContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-reference')) {
                        e.target.closest('.reference-entry').remove();
                        // Re-index remaining references if needed, or just rely on PHP to handle sparse arrays
                        // For simplicity, we'll let PHP handle it.
                    }
                });
            }

            updateStepVisibility();
        });
    </script>
</body>
</html>
