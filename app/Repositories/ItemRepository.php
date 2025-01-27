<?php 
    namespace App\Repositories;

    use App\Models\Item;
    use App\Repositories\Interfaces\ItemRepositoryInterface;
    use Illuminate\Support\Facades\Storage;

    class ItemRepository implements ItemRepositoryInterface {
        protected $model;   // Itemモデルのインスタンスを保持する変数

        // コンストラクタ：クラスのインスタンス作成時に実行される
        public function __construct(Item $item) {
            $this->model = $item;   // Itemモデルのインスタンスを保存
        }

        // インターフェースで定義したメソッドの実装
        // Itemsテーブルのレコードを作成
        public function create(array $data): Item {
            return Item::create($data);
        }

        public function saveImages(array $files, int $userId): array {
            // 画像ファイルを保存し、パスを取得
            $imagePaths = [];
            for ($i = 1; $i <= 4; $i++) {
                $imageField = "image_{$i}";
                if (isset($files[$imageField])) {
                    // フォルダパスを作成
                    $folderPath = "images/{$userId}";
                    Storage::disk('public')->makeDirectory($folderPath);

                    // ファイル名を生成して保存
                    $fileName = $files[$imageField]->getClientOriginalName();
                    $path = $files[$imageField]->storeAs($folderPath, $fileName, 'public');
                    $imagePaths[$imageField] = "storage/{$path}";
                } else {
                    $imagePaths[$imageField] = null;
                }
            }
            return $imagePaths;
        }

        // 商品名（あいまい検索）で検索
        public function searchByName(string $query) {
            return $this->model->with('user')   // userリレーションを事前ロード
                ->where('item_name', 'like', "%{$query}%")
                ->get();
        }

        public function getOtherItemsByUser(int $userId, int $currentItemId) {
            // ユーザーの他の出品物を取得
            return $this->model
                ->where('user_id', $userId)
                ->where('id', '!=', $currentItemId)     // 現在のアイテム以外
                ->get(['id', 'item_name', 'image_1']);  // IDも含めて取得
        }

        // 指定されたユーザーIDと出品状態に基づいてアイテムを取得する
        public function getByUserIdAndStatus(int $userId, string $listStatus) {
            return $this->model
                ->forUser($userId)          // ユーザーでフィルタ
                ->withStatus($listStatus)   // 出品状態でフィルタ
                ->latestFirst()             // 新しい順でソート
                ->get();                    // データを取得
        }

        // ユーザーのの他出品物（出品中）を取得（最大4件）
        public function findRelatedItems(int $userId, int $itemId, int $limit = 4) {
            return $this->model
                ->where('user_id', $userId)     // ユーザーでフィルタ
                ->where('id', '!=', $itemId)    // 現在のアイテム以外
                ->where('list_status', 0)       // 販売中の商品のみ
                ->latest()                      // 最新の商品から
                ->take($limit)                  // 4件まで
                ->get();                        // データを取得
        }

        // 出品状態を更新
        public function updateListStatus(Item $item, int $status): bool {
            return $item->update([
                'list_status' => $status
            ]);
        }

    }

?>