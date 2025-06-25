<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class RecruitmentController extends Controller
{
    // Centralized validation rules for each step
    private function getValidationRules($step)
    {
        $rules = [
            1 => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contact_number' => 'required|integer|min:10',
            ],
            2 => [
                'position_applied' => 'required|string|max:255',
                'dob' => 'required|date',
                'gender' => ['required', 'string', Rule::in(['male', 'female', 'other'])],
                'blood_group' => 'nullable|string|max:10',
                'marital_status' => ['required', 'string', Rule::in(['single', 'married', 'divorced', 'widowed'])],
                'nationality' => 'required|string|max:255',
            ],
            3 => [
                'present_address' => 'required|string',
                'permanent_address' => 'nullable|string',
            ],
            4 => [
                'education_qualification' => 'required|string|max:255',
                'total_experience' => 'required|integer|min:0',
                'relevant_experience' => 'nullable|integer|min:0',
                'current_ctc' => 'required|string|max:255', // Assuming CTC can be a string like "5 LPA"
                'expected_ctc' => 'required|string|max:255', // Assuming CTC can be a string like "7 LPA"
            ],
            5 => [
                'applied_before' => ['required', Rule::in(['yes', 'no'])],
                'applied_before_details' => 'required_if:applied_before,yes|nullable|string|max:1000',
            ],
            6 => [
                'has_relatives' => ['required', Rule::in(['yes', 'no'])],
                'relatives_details' => 'required_if:has_relatives,yes|nullable|string|max:1000',
            ],
            7 => [
                'references' => 'nullable|array',
                'references.*.name' => 'nullable|string|max:255',
                'references.*.designation' => 'nullable|string|max:255',
                'references.*.company' => 'nullable|string|max:255',
                'references.*.mobile' => 'nullable|string|max:20',
                'resume' => 'required|file|mimes:pdf|max:2048', // Resume is mandatory and PDF only
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Photo is optional
            ],
        ];
        return $rules[$step] ?? [];
    }

    public function showForm(Request $request)
    {
        // Allow step navigation via query parameter for the "Previous" button
        if ($request->has('step')) {
            $step = (int)$request->query('step');
            if ($step >= 1 && $step <= 7) {
                Session::put('current_step', $step);
            }
        }

        $formData = Session::get('job_application', []);
        return view('recruitment', compact('formData'));
    }

    public function storeStep(Request $request, $step)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules($step));

        if ($validator->fails()) {
            return redirect()->route('recruitment.show')->withErrors($validator)->withInput()->with('current_step', $step);
        }

        $formData = Session::get('job_application', []);

        // Merge form data
        // For array inputs like 'references', ensure they are merged correctly
        if (isset($this->getValidationRules($step)['references'])) {
            $formData['references'] = $request->input('references', []);
        }

        // IMPORTANT: Remove file storage from here. Files will be stored on final submit.
        // This prevents duplicate storage if user navigates back and forth.
        // File objects cannot be stored in session directly.
        // We only store other form data in session.
        $formData = array_merge($formData, $request->except(['_token', 'references', 'resume', 'photo']));
        Session::put('job_application', $formData);
        Session::put('current_step', $step);

        if ($step < 7) {
            return redirect()->route('recruitment.show')->with('current_step', $step + 1);
        }

        // If it's the last step, stay on the page to show the submit button
        return redirect()->route('recruitment.show')->with('current_step', $step);
    }

    public function submit(Request $request)
    {
        // Validate the final step (Step 7) data, including files.
        // This validation is crucial as it's the final check before processing.
        $validator = Validator::make($request->all(), $this->getValidationRules(7));

        if ($validator->fails()) {
            // If validation fails, redirect back to step 7 with errors
            return redirect()->route('recruitment.show')->withErrors($validator)->withInput()->with('current_step', 7);
        }

        // Retrieve all form data from session
        $formData = Session::get('job_application', []);

        // Now, handle file uploads and update formData with their paths
        if ($request->hasFile('resume')) {
            $formData['resume'] = $request->file('resume')->store('recruitment-applications/resumes');
        }
        if ($request->hasFile('photo')) {
            $formData['photo'] = $request->file('photo')->store('recruitment-applications/resumes');
        }

        // Ensure references are also updated from the final request, in case they were modified
        if ($request->has('references')) {
            $formData['references'] = $request->input('references');
        }

        // At this point, $formData contains all collected data, including file paths.
        // You would typically save $formData to the database or send it via email.
        // Example: \App\Models\JobApplication::create($formData);
        // Make sure you have a JobApplication model and migration set up for this.

        $resumePath = $formData['resume'];
        $resumeUrl = asset('storage/' . $resumePath);
        $photoPath = $formData['photo'] ?? null;
        $photoUrl = $photoPath ? asset('storage/' . $photoPath) : null;

        // Log the submission for debugging
        Log::info('Job Application Submitted', [
            'formData' => $formData,
            'resumePath' => $resumePath,
            'resumeUrl' => $resumeUrl,
            'photoPath' => $photoPath,
            'photoUrl' => $photoUrl,
        ]);


        Session::forget('job_application');
        Session::forget('current_step');

        return redirect()->route('recruitment.show')->with('success', 'Application submitted successfully!');
    }

    public function reset(Request $request)
    {
        Session::forget('job_application');
        Session::forget('current_step');
        return redirect()->route('recruitment.show')->with('success', 'Form reset successfully!');
    }
}
