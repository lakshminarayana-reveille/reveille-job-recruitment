@props(['formData'])

<div id="step-3" class="step {{ session('current_step', 1) == 3 ? '' : 'hidden' }}">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Position Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-form-input label="Job Title Applied For" name="job_title" id="job_title" type="text" :value="old('job_title', $formData['job_title'] ?? '')" required />
        <x-form-input label="Job Location" name="job_location" id="job_location" type="text" :value="old('job_location', $formData['job_location'] ?? '')" required />
        <x-form-select label="Preferred Work Type" name="work_type" id="work_type" :value="old('work_type', $formData['work_type'] ?? '')" :options="['' => 'Select', 'full-time' => 'Full-time', 'part-time' => 'Part-time', 'remote' => 'Remote', 'contract' => 'Contract']" required />
        <x-form-input label="Expected Salary" name="salary" id="salary" type="text" :value="old('salary', $formData['salary'] ?? '')" required />
        <x-form-date label="Available Start Date" name="start_date" id="start_date" :value="old('start_date', $formData['start_date'] ?? '')" required />
        <x-form-select label="How did you hear about this job?" name="source" id="source" :value="old('source', $formData['source'] ?? '')" :options="['' => 'Select', 'referral' => 'Referral', 'job-portal' => 'Job Portal', 'company-website' => 'Company Website', 'other' => 'Other']" required />
    </div>
</div>
