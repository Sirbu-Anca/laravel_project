<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * class Product
 * @property integer $id
 * @property string  $title
 * @property string  $description
 * @property float   $price
 * @property string  $image
 *
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
    ];

    /**
     * @return string
     */
    public function getPhotoUrl(): string
    {
        return asset('storage/products_images/' . $this->image);
    }

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id');
    }
}
