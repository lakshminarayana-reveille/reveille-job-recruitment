@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h2 class="text-2xl font-semibold text-white">Job Application Details</h2>
            </div>

            <!-- Content Section -->
            <div class="p-6 space-y-6">
                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                        <div class="text-gray-700">
                            <p><strong class="text-gray-900">Name:</strong> {{ $application['name'] }}</p>
                            <p><strong class="text-gray-900">Email:</strong> {{ $application['email'] }}</p>
                            <p><strong class="text-gray-900">Contact Number:</strong> {{ $application['contact_number'] }}</p>
                            <p><strong class="text-gray-900">Date of Birth:</strong> {{ \Carbon\Carbon::parse($application['dob'])->format('d-m-Y') }}</p>
                            <p><strong class="text-gray-900">Gender:</strong> {{ ucfirst($application['gender']) }}</p>
                            <p><strong class="text-gray-900">Blood Group:</strong> {{ $application['blood_group'] }}</p>
                            <p><strong class="text-gray-900">Marital Status:</strong> {{ ucfirst($application['marital_status']) }}</p>
                            <p><strong class="text-gray-900">Nationality:</strong> {{ $application['nationality'] }}</p>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-2">
                        <h3 class="text-lg font-medium text-gray-900">Address Details</h3>
                        <div class="text-gray-700">
                            <p><strong class="text-gray-900">Present Address:</strong><br>{{ $application['present_address'] }}</p>
                            <p><strong class="text-gray-900">Permanent Address:</strong><br>{{ $application['permanent_address'] ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900">Professional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 text-gray-700">
                        <div>
                            <p><strong class="text-gray-900">Position Applied:</strong> {{ $application['position_applied'] }}</p>
                            <p><strong class="text-gray-900">Education Qualification:</strong> {{ $application['education_qualification'] }}</p>
                            <p><strong class="text-gray-900">Total Experience:</strong> {{ $application['total_experience'] }} years</p>
                            <p><strong class="text-gray-900">Relevant Experience:</strong> {{ $application['relevant_experience'] }} years</p>
                        </div>
                        <div>
                            <p><strong class="text-gray-900">Current CTC:</strong> ₹{{ $application['current_ctc'] }} LPA</p>
                            <p><strong class="text-gray-900">Expected CTC:</strong> ₹{{ $application['expected_ctc'] }} LPA</p>
                        </div>
                    </div>
                </div>

                <!-- Company History -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900">Company History</h3>
                    <div class="text-gray-700 mt-4">
                        <p><strong class="text-gray-900">Applied Before:</strong> {{ $application['applied_before'] ? 'Yes' : 'No' }}</p>
                        <p><strong class="text-gray-900">Details (if applied before):</strong> {{ $application['applied_before_details'] ?: 'N/A' }}</p>
                        <p><strong class="text-gray-900">Has Relatives in Company:</strong> {{ $application['has_relatives'] ? 'Yes' : 'No' }}</p>
                        <p><strong class="text-gray-900">Relatives Details:</strong> {{ $application['relatives_details'] ?: 'N/A' }}</p>
                    </div>
                </div>

                <!-- References -->
                @if(count($application['references']) > 0)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900">References</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 text-gray-700">
                        @foreach ($application['references'] as $reference)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <p><strong class="text-gray-900">Name:</strong> {{ $reference['name'] ?: 'N/A' }}</p>
                                <p><strong class="text-gray-900">Designation:</strong> {{ $reference['designation'] ?: 'N/A' }}</p>
                                <p><strong class="text-gray-900">Company:</strong> {{ $reference['company'] ?: 'N/A' }}</p>
                                <p><strong class="text-gray-900">Mobile:</strong> {{ $reference['mobile'] ?: 'N/A' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- Documents -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900">Documents</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 text-gray-700">
                        <div>
                            <p><strong class="text-gray-900">Resume:</strong></p>
                            @if ($application['resume_path'])
                                <a href="{{ asset('storage/' . $application['resume_path']) }}" class="text-blue-600 hover:text-blue-800 underline" target="_blank">View Resume</a>
                            @else
                                <span class="text-gray-500">Not Uploaded</span>
                            @endif
                        </div>
                        <div>
                            <p><strong class="text-gray-900">Photo:</strong></p>
                            @if ($application['photo_path'])
                                <img src="{{ asset('storage/' . $application['photo_path']) }}" class="h-32 w-32 object-cover rounded-lg shadow-sm" alt="Applicant Photo">
                            @else
                                <span class="text-gray-500">Not Uploaded</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Application Date -->
                <div class="border-t pt-6">
                    <p class="text-gray-700"><strong class="text-gray-900">Applied On:</strong> {{ \Carbon\Carbon::parse($application['created_at'])->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
