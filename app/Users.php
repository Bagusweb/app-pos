<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Payments;
use App\Transactions;


class Users extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function payment()
    {
        return $this->hasMany(Payments::class, 'user_id', 'user_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transactions::class, 'user_id', 'user_id');
    }
}
