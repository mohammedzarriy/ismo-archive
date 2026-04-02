<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    protected $fillable = [
        'trainee_id',
        'user_id',
        'date_validation',
        'signature_scan',
        'observations',
    ];

    protected $casts = [
        'date_validation' => 'date',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}