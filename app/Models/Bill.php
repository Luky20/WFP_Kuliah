<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'Bills';

    public function customer()
    {
        return $this->belongsTo(customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(employee::class, 'employee_id');
    }
}
