<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @property Integer $id
 * @property string  $name
 * @property string  $contactDetails
 * @property string  $comments
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contactDetails',
        'comments',
    ];
    /**
     * @var mixed
     */

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('product_id', 'price');
    }
}
