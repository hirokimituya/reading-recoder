<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = ['date', 'content'];

    /**
     * 配列に表示する属性
     *
     * @var array
     */
    protected $visible = ['id', 'date', 'content'];
}
