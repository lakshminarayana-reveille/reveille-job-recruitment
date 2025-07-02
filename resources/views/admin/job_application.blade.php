@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
                            @if ($application['photo'])
                                <img src="{{ asset('storage/' . $application['photo']) }}" class="h-32 w-32 object-cover rounded-lg shadow-sm" alt="Applicant Photo">
                            @else
                                <span class="text-gray-500">Not Uploaded</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Response History -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900">Response History</h3>
                    @if ($application->responses && $application->responses->count() > 0)
                        <div class="mt-4 space-y-4">
                            @foreach ($application->responses->sortByDesc('created_at') as $response)
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <p><strong class="text-gray-900">Type:</strong> <span class="capitalize">{{ str_replace('_', ' ', $response->response_type) }}</span></p>
                                    <p><strong class="text-gray-900">Message:</strong> {{ $response->response_message ?: 'N/A' }}</p>
                                    <p><strong class="text-gray-900">Responded By:</strong> {{ $response->responded_by }}</p>
                                    <p><strong class="text-gray-900">Date:</strong> {{ \Carbon\Carbon::parse($response->created_at)->format('d-m-Y H:i') }}</p>
                                    @if ($response->response_type == 'interview')
                                        <div class="mt-2 pt-2 border-t">
                                            <h4 class="font-semibold">Interview Details:</h4>
                                            <p><strong class="text-gray-900">Date & Time:</strong> {{ \Carbon\Carbon::parse($response->date_of_interview)->format('d-m-Y') }} at {{ \Carbon\Carbon::parse($response->time_of_interview)->format('h:i A') }}</p>
                                            <p><strong class="text-gray-900">Location:</strong> {{ $response->interview_location }}</p>
                                            <p><strong class="text-gray-900">Mode:</strong> <span class="capitalize">{{ $response->interview_mode }}</span></p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-gray-500">No responses have been sent for this application yet.</p>
                    @endif
                </div>

                <!-- Application Date -->
                <div class="border-t pt-6">
                    <p class="text-gray-700"><strong class="text-gray-900">Applied On:</strong> {{ \Carbon\Carbon::parse($application['created_at'])->format('d-m-Y H:i') }}</p>
                </div>

                <!-- Actions -->
                <div class="border-t pt-6 text-right">
                    <button id="replyButton" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                        Respond to Application
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="responseModal" class="fixed inset-0 bg-[rgba(107,114,128,0.6)] overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center">
        <div class="relative p-6 w-full max-w-2xl bg-white rounded-xl shadow-2xl">
            <div class="flex justify-between items-center border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-900">Send Response</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700 transition">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.applications.response.store', $application->id) }}" method="POST" class="mt-4 space-y-5">
                @csrf
                <div>
                    <x-form-select
                        label="Response Type"
                        name="response_type"
                        id="response_type"
                        :value="old('response_type', $formData['response_type'] ?? '')"
                        :options="[
                            '' => 'Select a response type',
                            'interview' => 'Schedule Interview',
                            'accepted' => 'Accepted',
                            'rejected' => 'Rejected',
                            'on_hold' => 'On Hold' ]"
                        required
                    />
                </div>

                <div>
                    <x-form-input label="Response Message" name="response_message" id="response_message" type="textarea" required>{{ old('response_message', $formData['response_message'] ?? '') }}</x-form-input>
                </div>

                <div id="interview_fields" class="hidden border-t pt-4 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Interview Details</h3>
                    <div>
                        <x-form-date label="Date" name="date_of_interview" id="date_of_interview" type="date" required>{{ old('date_of_interview', $formData['date_of_interview'] ?? '') }}</x-form-date>
                    </div>
                    <div>
                        <x-form-date label="Time" name="time_of_interview" id="time_of_interview" type="time" required>{{ old('time_of_interview', $formData['time_of_interview'] ?? '') }}</x-form-date>
                    </div>
                    <div>
                        <x-form-input label="Location" name="interview_location" placeholder="Enter location" id="interview_location" type="text" required>{{ old('interview_location', $formData['interview_location'] ?? '') }}</x-form-input>
                    </div>
                    <div>
                        <x-form-select
                            label="Select mode"
                            name="interview_mode"
                            id="interview_mode"
                            :value="old('interview_mode', $formData['interview_mode'] ?? '')"
                            :options="[
                                '' => 'Select mode',
                                'in-person' => 'In-Person',
                                'online' => 'Online',
                                'telephonic' => 'Telephonic' ]"
                            required
                        />
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Send Response
                    </button>
                </div>
            </form>
        </div>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('responseModal');
            const replyButton = document.getElementById('replyButton');
            const closeModal = document.getElementById('closeModal');
            const responseTypeSelect = document.getElementById('response_type');
            const interviewFields = document.getElementById('interview_fields');

            function toggleInterviewFields() {
                if (responseTypeSelect.value === 'interview') {
                    interviewFields.classList.remove('hidden');
                    interviewFields.querySelectorAll('input, select').forEach(el => el.setAttribute('required', 'required'));
                } else {
                    interviewFields.classList.add('hidden');
                    interviewFields.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
                }
            }

            if (replyButton) {
                replyButton.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                });
            }

            if (closeModal) {
                closeModal.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            }

            window.addEventListener('click', (event) => {
                if (event.target == modal) {
                    modal.classList.add('hidden');
                }
            });

            if(responseTypeSelect) {
                responseTypeSelect.addEventListener('change', toggleInterviewFields);
            }

            // If there are validation errors, show the modal and interview fields if needed
            @if ($errors->any())
                modal.classList.remove('hidden');
                toggleInterviewFields();
            @endif
        });
    </script>
    @endpush
@endsection
