<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Relationship with favorites.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Accessor to check if the product is favorited by the authenticated user.
     */
    public function getIsFavoritedAttribute()
    {
        $user = auth()->user();

        if ($user) {
            return $this->favorites()->where('user_id', $user->id)->exists();
        }

        return false;
    }
}
