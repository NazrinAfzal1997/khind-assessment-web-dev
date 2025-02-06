<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
