<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //得意先ID
            'partner_id' => ['required', 'exists:business_partners,id'],

            //受注日
            'ordered_at' => ['required', 'date'],

            //倉庫ID
            'warehouse_id' => ['required', 'exists:warehouses,id'],

            //明細配列
            'items' => ['required', 'array', 'min:1'],

            //明細ごとのバリデーション
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty'        => ['required', 'numeric', 'gt:0'],
            'items.*.unit_price' => ['required', 'numeric', 'gte:0'],
            'items.*.tax_rate'   => ['nullable', 'numeric', 'between:0,20'], //任意：商品税率の上書き
        ];
    }

    //エラーメッセージ
    public function messages(): array
    {
        return [
            'partner_id.required' => '取引先を選択してください。',
            'partner_id_exists'   => '指定された取引先は存在しません。',
            'ordered_at.required' => '受注日を入力してください。',
            'warehouse_id.required' => '倉庫を選択してください。',
            'items.required' => '明細を１行以上入力してください。',
            'items.*.product_id.exists' => '商品が存在しません。',
            'items.*.qty.gt' => '数量は１以上で入力してください。',
        ];
    }

    //フロントからの不正キーを排除(validated()で返すデータ)
    public function validated($key = null, $default = null)
    {
        //明示的にルールに定義されたキーだけを返す
        return parent::validated($key, $default);
    }
}
