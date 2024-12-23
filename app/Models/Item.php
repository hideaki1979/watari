<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category', 
        'item_name', 
        'description', 
        'price', 
        'expiry_date', 
        'list_status',
        'image_1',
        'image_2',
        'image_3',
        'image_4'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
