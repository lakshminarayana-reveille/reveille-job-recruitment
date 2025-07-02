<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $query = JobApplication::query();

            if ($request->has('search') && $request->search != '') {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('contact_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('position_applied', 'like', '%' . $searchTerm . '%');
                });
            }

            $jobApplications = $query->paginate(5)->appends($request->only('search'));
            return view('admin.dashboard', compact('jobApplications'));
        }
        return redirect()->route('admin.login');
    }

    public function showJobApplication($id)
    {
        if (Auth::guard('admin')->check()) {
            $application = JobApplication::with('responses')->findOrFail($id);
            return view('admin.job_application', compact('application'));
        }
        return redirect()->route('admin.login');
    }

    public function storeResponse(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Rest of the method remains the same
    }

    public function userManagement()
    {
        if (Auth::guard('admin')->check()) {
            $admins = Admin::all();
            return view('admin.userManagement', compact('admins'));
        }
        return redirect()->route('admin.login');
    }

    public function createUser(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,manager,staff,hr,recruiter',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.userManagement')->with('success', 'User created successfully.');
    }
    public function updateUser(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,manager,staff,hr,recruiter',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role = $request->role;
        $admin->is_active = $request->status ? 1 : 0;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        return redirect()->route('admin.userManagement')->with('success', 'User updated successfully.');
    }
}
