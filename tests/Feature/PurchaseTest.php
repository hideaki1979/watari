<?php

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use function Pest\Laravel\{actingAs, get, post};
use Illuminatet\Supportt\Facadest\Hash;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->expiryDate = now()->addDays(7);

    $this->item = Item::factory()->create([
        'user_id' => $this->user->id,
        'category' => '01',
        'item_name' => '砂糖100g',
        'description' => '砂糖余りました',
        'price' => 100,
        'expiry_date' => now()->addDays(7),
        'list_status' => '0',
        'image_1' => 'storage/images/1/test.png',
    ]);
});

test('ユーザーは購入履歴を閲覧できる', function () {
    $user = $this->user;
    $item = $this->item;

    // 購入履歴を作成
    createPurchase($user->id, $item->id);

    // 購入履歴ページにアクセス
    $response = actingAs($user)->get(route('purchases.index'));

    $response->assertStatus(200)
        ->assertViewIs('purchases.index')
        ->assertSee('砂糖100g')
        ->assertSee('100')
        ->assertSee($this->expiryDate->format('Y/m/d'));
});

test('ユーザーは商品を購入できる', function () {
    $user = $this->user;
    $item = $this->item;

    $response = actingAs($user)
        ->post(route('purchases.purchase', $item));

    $response->assertStatus(200)
        ->assertViewIs('items.buy');

    // データベースに購入記録が作成されたことを確認
    $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'item_id' => $item->id,
    ]);

    // 商品のステータスが更新されたことを確認
    $this->assertDatabaseHas('items', [
        'id' => $item->id,
        'list_status' => '1',
    ]);
});

test('未認証ユーザーは購入できない', function () {
    $item = $this->item;

    $response = post(route('purchases.purchase', $item));

    $response->assertRedirect('/login');

    // 購入記録が作成されていないことを確認
    $this->assertDatabaseMissing('purchases', [
        'item_id' => $item->id,
    ]);
});

test('購入履歴は正しいユーザーと商品に紐付いている', function () {
    $user = $this->user;
    $item = $this->item;

    $purchase = createPurchase($user->id, $item->id);

    expect($purchase->user->id)->toBe($user->id)
        ->and($purchase->item->id)->toBe($item->id);
});

test('購入履歴は新しい順に表示される', function () {
    $user = $this->user;

    // 複数のアイテムを作成
    $item1 = Item::factory()->create([
        'user_id' => $user->id,
        'item_name' => '古い商品',
        'price' => 100,
    ]);

    $item2 = Item::factory()->create([
        'user_id' => $user->id,
        'item_name' => '新しい商品',
        'price' => 200,
    ]);

    // 複数の購入履歴を作成（異なる時間で）
    $purchase1 = createPurchase(
        $user->id,
        $item->id,
        ['created_at' => now()->subDay(1)]
    );

    $purchase2 =createPurchase(
        $user->id,
        $item->id,
        ['created_at' => now()]
    );

    // 購入履歴ページにアクセス
    $response = actingAs($user)->get(route('purchases.index'));

    $response->assertStatus(200)
        ->assertViewIs('purchases.index')
        // 新しい順（降順）になっていることを確認
        ->assertSeeInOrder([
            $item2->item_name,
            $item1->item_name
        ]);
});
