<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Telegram\Bot\Commands\Command;

class ImOutCommand extends Command
{
    protected $name = 'im-out';
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

        }

        $member = $chat
            ->members()
            ->where('ext_id', '=', $telegramMessage->user->id)
            ->get()
            ->first();

        if (!$member) {

        }

        $this->randomCoffee->removeMember($member);
    }
}