<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    protected $fillable = [
        'filiere_id',
        'cin',
        'cef',
        'first_name',
        'last_name',
        'date_naissance',
        'phone',
        'group',
        'graduation_year',
        'image_profile',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function validation()
    {
        return $this->hasOne(Validation::class);
    }
}