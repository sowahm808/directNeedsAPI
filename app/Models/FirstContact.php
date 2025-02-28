<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'processor_id',
        'contact_date',
        'contact_method'
    ];

    // Define relationships (Optional but recommended)
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processor_id');
    }
}
