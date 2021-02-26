<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Ramsey\Uuid\Type\Integer;

/**
 * @property Integer $id
 * @property Integer $order_id
 * @property integer $product_id
 * @property float   $price
 */
class OrderProduct extends Pivot
{
    use HasFactory;

}
