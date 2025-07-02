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
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-white">User Management</h2>
                    <button onclick="openModal()"
                        class="bg-blue-600 hover:bg-blue-700 cursor-pointer text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                        Add New User
                    </button>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6 space-y-6">
                <!-- User List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Role
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ $admin->name }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ $admin->email }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ Str::ucfirst($admin->role) }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <button onclick="openModal({{ $admin->id }})"
                                            class="text-blue-600 hover:text-blue-900 cursor-pointer">Edit</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal"
        class="fixed inset-0 bg-[rgba(107,114,128,0.6)] overflow-y-auto h-full w-full hidden z-50 content-center">
        <div class="relative mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white">
            <div class="mt-1 text-center">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Add/Edit User</h3>
                    <button onclick="closeModal()"
                        class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="userForm" class="mt-2 text-left" method="POST"
                    action="{{ route('admin.userManagement.create') }}">
                    @csrf
                    <input type="hidden" id="userId" name="id">
                    <div class="mb-3">
                        <x-form-input label="Name" name="name" id="name" type="text"
                            required>{{ old('name', $formData['name'] ?? '') }}</x-form-input>
                    </div>
                    <div class="mb-3">
                        <x-form-input label="Email address" name="email" id="email" type="email"
                            required>{{ old('email', $formData['email'] ?? '') }}</x-form-input>
                    </div>
                    <div class="mb-3">
                        <x-form-input label="Password" name="password" id="password" type="password"
                            required>{{ old('password', $formData['password'] ?? '') }}</x-form-input>
                    </div>
                    <div class="mb-3">
                        <x-form-input label="Confirm Password" name="password_confirmation" id="password_confirmation"
                            type="password"
                            required>{{ old('password_confirmation', $formData['password_confirmation'] ?? '') }}</x-form-input>
                    </div>
                    <div class="mb-3">
                        <x-form-select label="Role" name="role" id="role" :value="old('role', $formData['role'] ?? '')" :options="[
                            '' => 'Select a role',
                            'admin' => 'Admin',
                            'manager' => 'Manager',
                            'recruiter' => 'Recruiter',
                            'hr' => 'HR',
                        ]"
                            required />
                    </div>
                    <div class="mb-3" id="statusSection">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="flex flex-col mt-2 space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="active" name="status" value="1"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="inactive" name="status" value="0"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="inactive" class="ml-2 block text-sm text-gray-900">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 py-3">
                        <button id="saveButton" type="submit"
                            class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Save
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const admins = @json($admins);

            function openModal(userId = null) {
                const modal = document.getElementById('userModal');
                const form = document.getElementById('userForm');
                const submitButton = document.getElementById('saveButton');
                const titleEl = document.getElementById('modalTitle');
                const statusSection = document.getElementById('statusSection');

                if (userId) {
                    const data = admins.find(admin => admin.id == userId);
                    console.log(data)
                    if (!data) {
                        alert('User not found');
                        return;
                    }
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('role').value = data.role;
                    document.getElementById('password').removeAttribute('required');
                    document.getElementById('password_confirmation').removeAttribute('required');
                    if (data.is_active) {
                        document.getElementById('active').checked = true;
                    } else {
                        document.getElementById('inactive').checked = true;
                    }
                    titleEl.textContent = 'Edit User';
                    submitButton.textContent = 'Update User';
                    form.action = "{{ route('admin.userManagement.update', ':id') }}".replace(':id', data.id);
                    statusSection.style.display = 'block'
                } else {
                    titleEl.textContent = 'Add User';
                    submitButton.textContent = 'Save User';
                    form.action = '{{ route('admin.userManagement.create') }}';
                    statusSection.style.display = 'none'
                    form.reset();
                }

                modal.classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('userModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById('userModal');
                if (event.target == modal) {
                    closeModal();
                }
            }
        </script>
    @endpush
@endsection
