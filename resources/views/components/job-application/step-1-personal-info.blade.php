@props(['formData'])

<div id="step-1" class="step {{ session('current_step', 1) == 1 ? '' : 'hidden' }}">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-form-input label="First Name" name="first_name" id="first_name" type="text" :value="old('first_name', $formData['first_name'] ?? '')" required />
        <x-form-input label="Last Name" name="last_name" id="last_name" type="text" :value="old('last_name', $formData['last_name'] ?? '')" required />
        <x-form-input label="Email Address" name="email" id="email" type="email" :value="old('email', $formData['email'] ?? '')" required />
        <x-form-input label="Phone Number" name="phone" id="phone" type="tel" :value="old('phone', $formData['phone'] ?? '')" required />
        <x-form-date label="Date of Birth" name="dob" id="dob" :value="old('dob', $formData['dob'] ?? '')" required />
        <x-form-select label="Gender" name="gender" id="gender" :value="old('gender', $formData['gender'] ?? '')" :options="['' => 'Select', 'male' => 'Male', 'female' => 'Female', 'other' => 'Other']" required />
        <x-form-input label="Nationality" name="nationality" id="nationality" type="text" :value="old('nationality', $formData['nationality'] ?? '')" required />
    </div>
</div>
