<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'response_type',
        'response_message',
        'responded_by',
        'responded_to',
        'status',
        'date_of_interview',
        'time_of_interview',
        'interview_location',
        'interview_mode',
    ];

    protected $casts = [
        'date_of_interview' => 'date',
        'time_of_interview' => 'datetime',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
