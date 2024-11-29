<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transactions;

class Customers extends Model
{
    protected $table = 'tbl_customers';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'address',
        'member_status'
    ];

    public function transaction()
    {
        return $this->hasMany(Transactions::class, 'customer_id', 'customer_id');
    }
}
