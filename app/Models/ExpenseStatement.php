<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'total_grant_amount',
        'total_expense',
        'deductions'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
