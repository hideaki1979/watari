<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryFactory> */
    use HasFactory;

    protected $fillable = ['address', 'latitude', 'longitude', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // スコープメソッドの説明
    // scope という接頭辞をつけることで、クエリのフィルター条件として使えます
    public function scopeForUser($query, $userId) {
        return $query->where('user_id', $userId);
    }
}
