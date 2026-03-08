<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'category_id',
        'supplier_id',
        'brand',
        'size',
        'condition',
        'purchase_price',
        'selling_price',
        'quantity',
        'reorder_level',
        'color',
        'material',
        'status',
    ];

    /**
     * Category relationship.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Supplier relationship.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Stock movements relationship.
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Check if product is low on stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }
}
