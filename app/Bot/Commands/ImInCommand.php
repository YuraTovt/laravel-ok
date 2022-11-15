<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Telegram\Bot\Commands\Command;

class ImInCommand extends Command
{
    protected $name = 'im-in';
    protected $description = 'Start Command to get you started';
    protected RandomCoffee $randomCoffee;

    public function handle()
    {
        $telegramUpdate = $this->getUpdate();
        $telegramChat = $telegramUpdate->getChat();
        $telegramMessage = $telegramUpdate->getMessage();

        $chat = RandomCoffeeChat::query()
            ->where('ext_id', '=', $telegramChat->id)
            ->where('type', '=', 'telegram')
            ->get()
            ->first();

        if (!$chat) {
            $chat = $this->randomCoffee->registerChat($telegramChat->id, 'telegram');
        }

        $this->randomCoffee->registerMember(
            $telegramMessage->user->id,
            "{$telegramMessage->user->firstName} {$telegramMessage->user->lastName}",
            $chat
        );
    }
}