<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseHistoryTest extends TestCase {
    use RefreshDatabase;

    private User $user;
    private Item $item;

    protected function setUp(): void {
        parent::setUp();
        // ベースとなるユーザーとアイテムを作成
        $this->user = User::factory()->create([
            'name' => 'Test_User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->item = Item::factory()->create([
            'user_id' => $this->user->id,
            'category' => '01',
            'item_name' => '砂糖100g',
            'description' => '砂糖余りました',
            'price' => 100,
            'expiry_date' => now()->addDays(7),
            'list_status' => '0',
            'image_1' => 'storage/images/1/b355187937ed90fdc8c9eb06bf1bef11.png',
        ]);
    }

    public function test_user_can_view_purchase_history(): void {
        // 購入履歴の作成
        $purchase = Purchase::factory()->create([
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);

        // ログイン状態でアクセス
        $response = $this->actingAs($this->user)
            ->get(route('purchases.index'));

        $response ->assertStatus(200)
            ->assertViewIs('purchases.index')
            ->assertSee('砂糖100g')
            ->assertSee(100)
            ->assertSee(now()->addDays(7)->format('Y/m/d'))
            ->assertSeeInOrder([
                'src="' . asset($this->item->image_1) . '"',
                'alt="砂糖100g"'
            ]);
    }

    public function test_purchase_belongs_to_correct_user_and_item(): void {
        $purchase = Purchase::factory()->create([
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);

        $this->assertEquals($this->user->id, $purchase->user->id);
        $this->assertEquals($this->item->id, $purchase->item->id);
    }

    public function test_purchase_list_shows_correct_count(): void {
        // 複数の購入履歴を作成
        Purchase::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);

        $purchaseCount = Purchase::where('user_id', $this->user->id)->count();
        $this->assertEquals(3, $purchaseCount);
    }
}

?>