<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // ブログのタイトルと本文を保存できるようにする
    protected $fillable =
    [
        'title',
        'body',
    ];
}
