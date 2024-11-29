<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categories;

class Products extends Model
{
    protected $table = 'tbl_products';
    protected $primaryKey = 'product_id'; // Assuming 'ProductID' is the primary key

    protected $fillable = [
        'product_name',
        'category_id', // Foreign key for the ProductCategory relationship
        'product_description',
        'price',
        'stock',
        'photo'
    ];

    // Define the relationship to Category
    public function Categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }
}