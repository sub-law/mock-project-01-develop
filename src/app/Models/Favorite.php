<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // お気に入り登録したユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // お気に入り対象の商品
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
