<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryFactory> */
    use HasFactory;   // Factoryパターンを使用可能にするトレイトを追加

    // データベースに一括代入可能なカラムを指定
    protected $fillable = ['address', 'latitude', 'longitude', 'user_id'];

    // Userモデルとのリレーション設定
    public function user() {
        return $this->belongsTo(User::class);   // 1つの配送は1人のユーザーに属することを定義
    }

    // スコープメソッドの説明
    // scope という接頭辞をつけることで、クエリのフィルター条件として使えます
    // ローカルスコープの定義
    // $queryは自動的に渡されるクエリビルダーのインスタンス
    // $userIdは検索対象のユーザーID
    public function scopeForUser($query, $userId) {
        // 指定されたユーザーIDに一致するレコードのみを取得するクエリを返す
        return $query->where('user_id', $userId);
    }
}
