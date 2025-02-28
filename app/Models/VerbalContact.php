<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerbalContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'processor_id',
        'contact_successful',
        'contact_notes',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processor_id');
    }
}

