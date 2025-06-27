<?php

namespace App\Http\Controllers\Admin;
// namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationResponse;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            // $jobApplications = JobApplication::all();
            // return view('admin.dashboard', compact('jobApplications'));
            $query = JobApplication::query();

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('contact_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('position_applied', 'like', '%' . $searchTerm . '%');
                });
            }

            $jobApplications = $query->paginate(2)->appends($request->only('search'));
            return view('admin.dashboard', compact('jobApplications'));
        }
        return redirect('admin.login');
    }

    public function showJobApplication($id)
    {
        if (Auth::guard('admin')->check()) {
            $application = JobApplication::with('responses')->findOrFail($id);
            return view('admin.job_application', compact('application'));
        }
        return redirect('admin.login');
    }

    public function storeResponse(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('admin.login');
        }

        $jobApplication = JobApplication::findOrFail($id);

        $rules = [
            'response_type' => 'required|string|in:accepted,rejected,interview,on_hold',
            'response_message' => 'nullable|string|max:5000',
        ];

        if ($request->input('response_type') === 'interview') {
            $rules['date_of_interview'] = 'required|date';
            $rules['time_of_interview'] = 'required';
            $rules['interview_location'] = 'required|string|max:255';
            $rules['interview_mode'] = 'required|string|in:in-person,online,telephonic';
        }

        $validatedData = $request->validate($rules);

        JobApplicationResponse::create([
            'job_application_id' => $jobApplication->id,
            'response_type' => $validatedData['response_type'],
            'response_message' => $validatedData['response_message'] ?? null,
            'responded_by' => Auth::guard('admin')->user()->name, // Assuming admin has a name
            'responded_to' => $jobApplication->email, // Responding to the applicant
            'status' => 'completed',
            'date_of_interview' => $validatedData['date_of_interview'] ?? null,
            'time_of_interview' => $validatedData['time_of_interview'] ?? null,
            'interview_location' => $validatedData['interview_location'] ?? null,
            'interview_mode' => $validatedData['interview_mode'] ?? null,
        ]);

        return redirect()->route('admin.applications.show', $id)->with('success', 'Response sent successfully.');
    }
}
