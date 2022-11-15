<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Telegram\Bot\Commands\Command;

class RandomCoffeeCommand extends Command
{
    protected $name = 'random-coffee';
    protected $description = 'Generate random coffee';
    protected RandomCoffee $randomCoffee;

    public function __construct(RandomCoffee $randomCoffee)
    {
        $this->randomCoffee = $randomCoffee;
    }

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