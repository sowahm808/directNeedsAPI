<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'assigned_processor_id',
        'status',
        'grant_amount',
        'approval_date',
        // New fields from the needs submission form:
        'name',
        'street_address',
        'apartment',
        'city',
        'state',
        'zip',
        'phone',
        'email',
        'role', // e.g., "Parent", "Caregiver", etc.
        'children_count',
        'children_details', // e.g., "Female, 12; Male, 8"
        'assistance_needed', // e.g., "Housing Assistance, Utilities"
        'snap_benefits',     // boolean
        'circumstance_details',
        'essential_needs',   // e.g., "Legal Assistance, Respite Care"
        'essential_circumstances',
        'supporting_documents' // store file path or URL
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'assigned_processor_id');
    }

    public function notes()
    {
        return $this->hasMany(ApplicationNote::class, 'application_id');
    }

    public function diaryReminders()
    {
        return $this->hasMany(DiaryReminder::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }

    public function expenseStatement()
    {
        return $this->hasOne(ExpenseStatement::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Scopes for filtering statuses
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeDenied($query)
    {
        return $query->where('status', 'denied');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }
}
