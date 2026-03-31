<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'm_customers';
    protected $fillable = ['name', 'city', 'phone'];
    public $timestamps = false;
}
