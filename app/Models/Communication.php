<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'type',
        'subject',
        'message',
        'sent_date'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
