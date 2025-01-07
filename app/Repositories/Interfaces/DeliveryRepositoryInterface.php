<?php
namespace App\Repositories\Interfaces;

interface DeliveryRepositoryInterface {
    // リポジトリで実装すべきメソッドを定義
    // 特定ユーザーの最初の1レコード目の配送情報を取得するメソッドを宣言
    public function findByUserId(int $userId);
    // 特定ユーザーの全配送情報を取得するメソッドを宣言
    public function getAllByUser(int $userId);
}

?>