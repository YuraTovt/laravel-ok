<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RandomCoffeeChat extends Model
{
    public function members(): HasMany
    {
        return $this->hasMany(RandomCoffeeChatMember::class, 'random_coffee_chat_id');
    }
}
