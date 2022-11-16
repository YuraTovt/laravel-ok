<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Telegram\Bot\Commands\Command;

class ImInCommand extends Command
{
    protected $name = 'imin';
    protected $description = 'Join random coffee';
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
                $chat = $this->randomCoffee->registerChat(
                    $telegramChat->id,
                    "Chat {$telegramChat->id}"
                );
            }

            $this->randomCoffee->registerMember(
                $telegramUser->id,
                "{$telegramUser->firstName} {$telegramUser->lastName}",
                $chat
            );

            $this->replyWithMessage(['text' => 'Done']);
        } catch (\Exception $exception) {
            $this->replyWithMessage(['text' => "Oops. Something is wrong. {$exception->getMessage()}"]);
        }
    }
}