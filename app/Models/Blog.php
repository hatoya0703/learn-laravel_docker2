<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // $fillableプロパティに、保存できるカラムを指定する
    protected $fillable =
    [
        'title',
        'body',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
