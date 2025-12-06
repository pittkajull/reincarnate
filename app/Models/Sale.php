<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'category',
        'price',
        'qty',
    ];

    protected $casts = [
        'price' => 'integer',
        'qty' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

