<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'address', 'registration_number', 'contact_number', 'program_id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
