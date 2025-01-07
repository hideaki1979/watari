<?php
namespace App\Repositories\Interfaces;

interface DeliveryRepositoryInterface {
    public function findByUserId(int $userId);
    public function getAllByUser(int $userId);
}

?>