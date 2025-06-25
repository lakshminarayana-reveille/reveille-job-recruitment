<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RecruitmentController extends Controller
{
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
        $validators = [
            1 => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'contact_number' => 'required|integer|min:10|digits_between:10,10',
            ],
            2 => [
                'position_applied' => 'required|string|max:255',
                'dob' => 'required|date',
                'gender' => 'required|string|in:male,female',
                'blood_group' => 'nullable|string|max:10',
                'marital_status' => 'required|string|in:single,married,divorced,widowed',
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
                'applied_before' => 'required|in:yes,no',
                'applied_before_details' => 'required_if:applied_before,yes|nullable|string|max:1000',
            ],
            6 => [
                'has_relatives' => 'required|in:yes,no',
                'relatives_details' => 'required_if:has_relatives,yes|nullable|string|max:1000',
            ],
            7 => [
                'references' => 'nullable|array',
                'references.*.name' => 'nullable|string|max:255',
                'references.*.designation' => 'nullable|string|max:255',
                'references.*.company' => 'nullable|string|max:255',
                'references.*.mobile' => 'nullable|string|max:20',
            ],
        ];

        $validator = Validator::make($request->all(), $validators[$step] ?? []);

        if ($validator->fails()) {
            return redirect()->route('recruitment.show')->withErrors($validator)->withInput()->with('current_step', $step);
        }

        $formData = Session::get('job_application', []);

        // Merge form data
        // For array inputs like 'references', ensure they are merged correctly
        if (isset($validators[$step]['references'])) {
            $currentReferences = $formData['references'] ?? [];
            $newReferences = $request->input('references', []);
            // This simple merge will overwrite existing references if keys match.
            // For dynamic arrays, you might need more sophisticated merging if you want to preserve specific old entries.
            // For this multi-step form, we assume the user is editing the current step's data.
            $formData['references'] = $newReferences;
        }

        $formData = array_merge($formData, $request->except(['_token', 'references'])); // Exclude 'references' if handled separately
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
        // It's highly recommended to re-validate all collected data here before final submission
        // to ensure data integrity, as users could skip steps or manipulate session data.
        // For brevity, this example assumes data is valid from previous steps.

        $formData = Session::get('job_application', []);

        // Here, you would typically save $formData to the database or send it via email.
        // Example: \App\Models\JobApplication::create($formData);
        // Make sure you have a JobApplication model and migration set up for this.

        // For now, we'll clear the session and show a success message
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
