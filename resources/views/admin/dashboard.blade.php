@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white border border-gray-300 rounded-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h2 class="text-2xl font-semibold text-white">Job Applications</h2>
            </div>

            <!-- Table Section -->
            <div class="p-3">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase tracking-wide">
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-left">Position Applied</th>
                                <th class="py-3 px-6 text-left">Submission Date</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @foreach($jobApplications as $application)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-6">{{ $application['name'] }}</td>
                                    <td class="py-4 px-6">{{ $application['email'] }}</td>
                                    <td class="py-4 px-6">{{ $application['position_applied'] }}</td>
                                    <td class="py-4 px-6">{{ $application['created_at']->format('d-m-Y') }}</td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('admin.applications.show', $application['id']) }}"
                                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
