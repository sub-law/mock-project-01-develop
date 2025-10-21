<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Comment;
use App\Models\Favorite;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'name',
        'status',
        'brand',
        'description',
        'image_path',
        'category',
        'condition',
        'price',
    ];

    // 出品者（1商品に1人）
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // 購入者（1商品に1人）
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // 購入情報（1対1）
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    // コメント（1商品に複数）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // お気に入り（1商品に複数）
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Product.php に追加

    public function getIsSoldAttribute()
    {
        return !is_null($this->buyer_id);
    }
}
