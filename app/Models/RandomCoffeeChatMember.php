<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RandomCoffeeChatMember extends Model
{
    public function chat(): BelongsTo
    {
        return $this->belongsTo(RandomCoffeeChat::class, 'random_coffee_chat_id');
    }
}
