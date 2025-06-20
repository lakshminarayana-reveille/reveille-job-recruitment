<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    public function showForm()
    {
        $formData = Session::get('job_application', []);
        return view('job-application', compact('formData'));
    }

    public function storeStep(Request $request, $step)
    {
        $validators = [
            1 => [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'dob' => 'required|date',
                'gender' => 'required|string|in:male,female,other',
                'nationality' => 'required|string|max:255',
            ],
            2 => [
                'current_address' => 'required|string',
                'permanent_address' => 'nullable|string',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip' => 'required|integer|min:6',
                'country' => 'required|string|max:255',
            ],
            3 => [
                'job_title' => 'required|string|max:255',
                'job_location' => 'required|string|max:255',
                'work_type' => 'required|string|in:full-time,part-time,remote,contract',
                'salary' => 'required|string|max:255',
                'start_date' => 'required|date',
                'source' => 'required|string|in:referral,job-portal,company-website,other',
            ],
            4 => [
                'education' => 'required|array|min:1',
                'education.*.degree' => 'required|string|max:255',
                'education.*.institution' => 'required|string|max:255',
                'education.*.year_passing' => 'required|integer|min:1900|max:' . date('Y'),
                'education.*.gpa' => 'required|string|max:10',
                'experience' => 'required|array|min:1',
                'experience.*.company' => 'required|string|max:255',
                'experience.*.job_title' => 'required|string|max:255',
                'experience.*.duration_start' => 'required|date',
                'experience.*.duration_end' => 'nullable|date|before_or_equal:experience.*.duration_start',
                'experience.*.currently_working' => 'nullable|boolean',
                'experience.*.responsibilities' => 'required|string',
            ],
            5 => [
                'skills' => 'required|string',
                // 'certifications' => 'nullable|array',
                // 'certifications.*.name' => 'nullable|string|max:255',
                // 'certifications.*.authority' => 'nullable|string|max:255',
                // 'certifications.*.year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'portfolio' => 'nullable|file|max:2048',
                'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'relocate' => 'required|string|in:yes,no',
                'eligible' => 'required|string|in:yes,no',
                'notice_period' => 'required|integer|min:0',
                'references_name' => 'nullable|string|max:255',
                'references_contact' => 'nullable|string|max:255',
                'references_relationship' => 'nullable|string|max:255',
                'comments' => 'required|string',
                'declaration' => 'required|accepted',
                'consent' => 'required|accepted',
            ],
        ];

        $validator = Validator::make($request->all(), $validators[$step] ?? []);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('current_step', $step);
        }

        $formData = Session::get('job_application', []);

        // Handle file uploads for step 5
        if ($step == 5) {
            if ($request->hasFile('resume')) {
                $formData['resume'] = $request->file('resume')->store('job-applications');
            }
            if ($request->hasFile('cover_letter')) {
                $formData['cover_letter'] = $request->file('cover_letter')->store('job-applications');
            }
            if ($request->hasFile('portfolio')) {
                $formData['portfolio'] = $request->file('portfolio')->store('job-applications');
            }
            if ($request->hasFile('photo')) {
                $formData['photo'] = $request->file('photo')->store('job-applications');
            }
            if ($request->hasFile('certificates')) {
                $formData['certificates'] = [];
                foreach ($request->file('certificates') as $certificate) {
                    $formData['certificates'][] = $certificate->store('job-applications');
                }
            }
        }

        // Merge form data
        $formData = array_merge($formData, $request->except(['_token', 'resume', 'cover_letter', 'portfolio', 'certificates', 'photo']));
        Session::put('job_application', $formData);
        Session::put('current_step', $step);

        if ($step < 5) {
            return redirect()->route('job-application.show')->with('current_step', $step + 1);
        }

        return redirect()->route('job-application.show')->with('current_step', $step);
    }

    public function submit(Request $request)
    {
        $formData = Session::get('job_application', []);

        // Here, you can save $formData to the database or send it via email
        // For now, we'll clear the session and show a success message
        Session::forget('job_application');
        Session::forget('current_step');

        return redirect()->route('job-application.show')->with('success', 'Application submitted successfully!');
    }

    public function saveDraft(Request $request)
    {
        // Save current session data (no action needed as it's already in session)
        return redirect()->back()->with('success', 'Form saved as draft!');
    }

    public function reset(Request $request)
    {
        Session::forget('job_application');
        Session::forget('current_step');
        return redirect()->route('job-application.show')->with('success', 'Form reset successfully!');
    }
}
