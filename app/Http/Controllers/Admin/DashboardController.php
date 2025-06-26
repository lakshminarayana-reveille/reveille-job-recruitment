<?php

namespace App\Http\Controllers\Admin;
// namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $jobApplications = JobApplication::all();
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
