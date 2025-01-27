<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  // 正しいインポート

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
    ];

    public function item(): BelongsTo {
        // return $this->belongsTo(Item::class, 'item_id', 'id');
        return $this->belongsTo(Item::class);
    }

    public function user(): BelongsTo {
        // return $this->belongsTo(User::class, 'user_id', 'id');
        return $this->belongsTo(User::class);
    }
}
