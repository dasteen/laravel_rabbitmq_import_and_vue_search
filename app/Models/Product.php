<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded;

    protected $appends = [
        'description_mini',
        'link',
        'human_price'
    ];

    const FIELDS_CONFIG = [
        'external_id' => [
            'original_name' => '@attributes.id',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'price' => [
            'original_name' => 'price',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'currency' => [
            'original_name' => 'currencyId',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'name' => [
            'original_name' => 'name',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'available' => [
            'original_name' => '@attributes.available',
            'is_required' => false,
            'is_boolean' => true,
        ],
        'url' => [
            'original_name' => 'url',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'category_id' => [
            'original_name' => 'categoryId',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'picture' => [
            'original_name' => 'picture',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'local_delivery_cost' => [
            'original_name' => 'local_delivery_cost',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'vendor' => [
            'original_name' => 'vendor',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'description' => [
            'original_name' => 'description',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'sales_notes' => [
            'original_name' => 'sales_notes',
            'is_required' => false,
            'is_boolean' => false,
        ],
        'manufacturer_warranty' => [
            'original_name' => 'manufacturer_warranty',
            'is_required' => false,
            'is_boolean' => true,
        ],
        'store' => [
            'original_name' => 'store',
            'is_required' => false,
            'is_boolean' => true,
        ],
        'pickup' => [
            'original_name' => 'pickup',
            'is_required' => false,
            'is_boolean' => true,
        ],
        'delivery' => [
            'original_name' => 'delivery',
            'is_required' => false,
            'is_boolean' => true,
        ],
    ];

    public function getDescriptionMiniAttribute() {
        return mb_substr($this->description, 0, 200);
    }

    public function getLinkAttribute() {
        return route('items.show', $this->id);
    }

    public function getHumanPriceAttribute() {
        return $this->price . ' ' . $this->currency;
    }

}
