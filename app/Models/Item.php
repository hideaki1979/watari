<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    // $fillable は、一括代入可能なフィールドを指定します
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

    // スコープメソッドの説明
    // scope という接頭辞をつけることで、クエリのフィルター条件として使えます
    
    // 特定の出品状態のアイテムにスコープを設定
    public function scopeWithStatus($query, string $status) {
        return $query->where('list_status', $status);
    }

    // 特定のユーザーのアイテムにスコープを設定
    public function scopeForUser($query, int $userId) {
        return $query->where('user_id', $userId);
    }

    // 作成日時の降順でソートするスコープ
    public function scopeLatestFirst($query) {
        return $query->orderBy('created_at', 'desc');
    }
}
