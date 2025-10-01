<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    public function bills()
    {
        return $this->hasMany(Bills::class, 'customer_id');
    }

}
