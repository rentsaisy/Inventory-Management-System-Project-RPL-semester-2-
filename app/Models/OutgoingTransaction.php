<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingTransaction extends Model
{
    protected $table = 't_outgoing_transactions';
    protected $fillable = ['product_id', 'customer_id', 'quantity', 'transaction_date'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
