<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $fillable = ['productvar_id', 'quantity'];

    public function variant()
    {
        return $this->belongsTo(productvar::class, 'productvar_id');
    }
}
