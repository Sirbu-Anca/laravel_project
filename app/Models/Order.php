<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @property Integer $id
 * @property string  $name
 * @property string  $contact_details
 * @property string  $comments
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_details',
        'comments',
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('product_id', 'price');
    }
}
