<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;
class Categories extends Model
{
    protected $table = 'tbl_categories';
    protected $primaryKey='category_id';

    protected $fillable=[
        'category_name',
        'description'
    ];

    // Example of a relationship
    public function Products()
    {
        return $this->hasMany(Products::class, 'category_id', 'category_id'); // Assuming you have a Product model
    }

}