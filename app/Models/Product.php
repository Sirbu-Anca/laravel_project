<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * class Product
 * @property integer $id
 * @property string  $title
 * @property string  $description
 * @property float   $price
 * @property string  $image_name
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
        'image_name',
    ];
}
