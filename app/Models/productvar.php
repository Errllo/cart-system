<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productvar extends Model
{
    protected $table = 'productvars';
    protected $fillable = ['product_id', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(cart::class, 'productvar_id');
    }
}
