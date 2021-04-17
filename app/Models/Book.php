<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * モデルのIDを自動増分するか
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * 自動増分IDのデータ型
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * 配列に対して非表示にする必要がある属性
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'price',
        'author',
        'publisher',
        'published',
        'image',
    ];

    /**
     * Comment リレーション
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
