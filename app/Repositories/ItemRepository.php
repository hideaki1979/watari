<?php 
    namespace App\Repositories;

    use App\Models\Item;
    use App\Repositories\Interfaces\ItemRepositoryInterface;
    use Illuminate\Support\Facades\Storage;

    class ItemRepository implements ItemRepositoryInterface {
        protected $model;

        public function __construct(Item $item) {
            $this->model = $item;
        }

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
    }

?>