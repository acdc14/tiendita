<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $fillable = ['date', 'product', 'user', 'quantiy', 'total'];

    /**
     * Get the product
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product');
    }

    /**
     * Get the user
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user');
    }
}
