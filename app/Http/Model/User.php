<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';// 因为在config中已经设置了 prefix，这里就不用写表名的前缀
    protected $primaryKey = 'user_id';
    public $timestamps = false;
}
