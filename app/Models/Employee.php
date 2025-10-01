<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    public function bills()
    {
        return $this->hasMany(Bills::class, 'employee_id');
    }
}
