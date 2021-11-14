<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pocket extends Model
{

    protected $table = "pockets";

    protected $fillable = [
        'pocket_name'
    ];

}
