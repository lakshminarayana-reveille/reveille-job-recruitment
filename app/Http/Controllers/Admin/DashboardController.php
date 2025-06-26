<?php

namespace App\Http\Controllers\Admin;
// namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

            $jobApplications = $query->paginate(10)->appends($request->only('search'));
            return view('admin.dashboard', compact('jobApplications'));
        }
        return redirect('admin.login');
    }

    public function showJobApplication($id)
    {
        if (Auth::guard('admin')->check()) {
            $application = JobApplication::findOrFail($id);
            return view('admin.job_application', compact('application'));
        }
        return redirect('admin.login');
    }
}
