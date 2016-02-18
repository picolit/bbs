<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockIp extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
}