<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'm_products';
    public $timestamps = false;
    protected $fillable = ['sku', 'name', 'category_id', 'supplier_id', 'condition_status', 'price', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
