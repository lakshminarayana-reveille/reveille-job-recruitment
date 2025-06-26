@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white border border-gray-300 rounded-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-white">Job Applications</h2>
            </div>

            <!-- Search and Filters -->
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <form action="{{ route('admin.applications') }}" method="GET">
                    <div class="flex justify-end items-center space-x-4">
                        <div class="relative flex-grow max-w-md">
                            <input type="text" name="search" placeholder="Search by name, email, position..."
                                value="{{ request('search') }}"
                                class="w-full min-w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Search
                        </button>
                        @if (request('search'))
                            <a href="{{ route('admin.applications') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>



            <!-- Table Section -->
            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase tracking-wide">
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-left">Position Applied</th>
                                <th class="py-3 px-6 text-left">Submission Date</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($jobApplications as $application)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">{{ $application->name }}</td>
                                    <td class="py-4 px-6">{{ $application->email }}</td>
                                    <td class="py-4 px-6">{{ $application->position_applied }}</td>
                                    <td class="py-4 px-6">{{ $application->created_at->format('d-m-Y') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('admin.applications.show', $application->id) }}"
                                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-500">
                                        No job applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Section -->
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                {{ $jobApplications->links() }}
            </div>
        </div>
    </div>
@endsection
