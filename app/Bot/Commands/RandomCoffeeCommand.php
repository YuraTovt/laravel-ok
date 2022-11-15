<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class RandomCoffeeCommand extends Command
{
    protected $name = 'random-coffee';
    protected $description = 'Start Command to get you started';
    protected RandomCoffee $randomCoffee;

    public function handle()
    {
        $telegramUpdate = $this->getUpdate();
        $telegramChat = $telegramUpdate->getChat();

        $chat = RandomCoffeeChat::query()
            ->where('ext_id', '=', $telegramChat->id)
            ->where('type', '=', 'telegram')
            ->get()
            ->first();

        $pairs = $this->randomCoffee->generatePairs($chat);
    }
}