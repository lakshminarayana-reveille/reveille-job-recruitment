<!DOCTYPE html>
<html>

<head>
    <title>Job Recruitment Form</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gradient-to-br from-yellow-100 via-green-100 to-red-100 min-h-screen flex items-center justify-center p-4">
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
                <span class="text-sm font-medium text-gray-700">Step <span id="currentStep">1</span> of 5</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 20%"></div>
            </div>
        </div>

        <!-- Form -->
        <form id="jobForm" class="space-y-6" action="{{ route('job-application.store-step', ['step' => session('current_step', 1)]) }}" method="POST" enctype="multipart/form-data">
            <!-- Step 1: Personal Information -->
            <div id="step-1" class="space-y-6 step">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input label="First Name" name="firstName" type="text" placeholder="Enter your first name" required />
                    <x-form-input label="Last Name" name="lastName" type="text" placeholder="Enter your last name" required />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input label="Email Address" name="email" type="email" placeholder="Enter your email address" required />
                    <x-form-input label="Phone Number" name="phone" type="number" placeholder="Enter your phone number" required />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-date label="Date of Birth" name="dob" required />
                    <x-form-select label="Gender (Optional)" value="" name="gender" :options="['' => 'Select', 'male' => 'Male', 'female' => 'Female', 'other' => 'Other']" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input label="Nationality" name="nationality" type="text" placeholder="Enter your nationality" required />
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button type="button" id="prevBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400" disabled>Previous</button>
                <button type="button" id="nextBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Next</button>
                <button type="submit" id="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 hidden">Submit</button>
            </div>
        </form>
    </div>
</body>

<script>
    let currentStep = 1;
    const totalSteps = 5;
    const steps = document.querySelectorAll('.step');
    const progressBar = document.getElementById('progressBar');
    const currentStepDisplay = document.getElementById('currentStep');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('jobForm');

</script>

</html>
