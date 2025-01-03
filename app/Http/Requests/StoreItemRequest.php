<?php  
    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreItemRequest extends FormRequest {
        public function rules(): array {
            return [
                'category' => 'required|string|max:2',
                'item_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|integer|min:1',
                'expiry_date' => 'required|date',
                'image_1' => 'nullable|file|mimes:jpg,jpeg,png|max:8192',
                'image_2' => 'nullable|file|mimes:jpg,jpeg,png|max:8192',
                'image_3' => 'nullable|file|mimes:jpg,jpeg,png|max:8192',
                'image_4' => 'nullable|file|mimes:jpg,jpeg,png|max:8192',
            ];
        }
    }

?>