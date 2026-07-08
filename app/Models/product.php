<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [ 'name' ];

    public function variants()
    {
        return $this->hasMany(productvar::class, 'product_id');
    }
}
