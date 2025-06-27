<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'position_applied',
        'dob',
        'gender',
        'blood_group',
        'marital_status',
        'nationality',
        'present_address',
        'permanent_address',
        'education_qualification',
        'total_experience',
        'relevant_experience',
        'current_ctc',
        'expected_ctc',
        'applied_before',
        'applied_before_details',
        'has_relatives',
        'relatives_details',
        'references',
        'resume_path',
        'photo_path',
    ];

    protected $casts = [
        'dob' => 'date',
        'applied_before' => 'boolean',
        'has_relatives' => 'boolean',
        'photo_path' => 'string', // Ensure photo_path is cast correctly if needed, or just remove if not a specific cast
        'references' => 'array',
    ];

    /**
     * Get the responses for the job application.
     */
    public function responses()
    {
        return $this->hasMany(JobApplicationResponse::class);
    }
}
