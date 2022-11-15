<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Telegram\Bot\Commands\Command;

class ImOutCommand extends Command
{
    protected $name = 'imout';
    protected $description = 'Leave random coffee';
    protected RandomCoffee $randomCoffee;

    public function __construct(RandomCoffee $randomCoffee)
    {
        $this->randomCoffee = $randomCoffee;
    }

    public function handle()
    {
        $telegramUpdate = $this->getUpdate();
        $telegramChat = $telegramUpdate->getChat();
        $telegramUser = $telegramUpdate->getMessage()->from;

        try {
            $chat = RandomCoffeeChat::query()
                ->where('ext_id', '=', $telegramChat->id)
                ->where('type', '=', 'telegram')
                ->get()
                ->first();

            if (!$chat) {
                $this->replyWithMessage(['text' => 'This chat does not support random coffee']);
            }

            $member = $chat
                ->members()
                ->where('ext_id', '=', $telegramUser->id)
                ->get()
                ->first();

            if (!$member) {
                $this->replyWithMessage(['text' => 'You are not member']);
            }

            $this->randomCoffee->removeMember($member);

            $this->replyWithMessage(['text' => 'Done']);
        } catch (\Exception $exception) {
            $this->replyWithMessage(['text' => "Oops. Something is wrong. {$exception->getMessage()}"]);
        }
    }
}