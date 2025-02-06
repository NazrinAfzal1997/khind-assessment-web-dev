<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'program_id',
        'registration_number',
        'contact_number',
        'start_program_date',
        'end_program_date',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'start_program_date',
        'end_program_date',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
