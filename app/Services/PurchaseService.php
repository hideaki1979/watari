<?php

namespace App\Services;

use App\Models\Item;
use App\Repositories\Interfaces\PurchaseRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseService
{
    private $purchaseRepository;
    private $itemRepository;

    public function __construct(
        PurchaseRepositoryInterface $purchaseRepository,
        ItemRepositoryInterface $itemRepository
    ) {
        $this->purchaseRepository = $purchaseRepository;
        $this->itemRepository = $itemRepository;
    }

    public function processPurchase(Item $item)
    {
        return DB::transaction(function () use ($item) {
            // 商品ステータスの更新
            $this->itemRepository->updateListStatus($item, 1);

            // 購入履歴の作成
            return $this->purchaseRepository->create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ]);
        });
    }
}
