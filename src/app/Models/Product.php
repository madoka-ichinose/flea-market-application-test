<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'product_name', 'brand', 'price', 'description',
        'category_id', 'condition', 'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function products()
    {
    return $this->belongsToMany(Product::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
    return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function getIsSoldAttribute()
    {
    
    return $this->purchases()->exists();
    }

    public function isSold()
    {
    return $this->is_sold;
    }

    public function seller()
    {
    return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
    return $this->belongsTo(User::class, 'buyer_id');
    }

    public function isFavoritedBy($user)
    {
    return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
