<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
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
            $this->randomCoffee->removeMember(
                $telegramChat->id,
                $telegramUser->id
            );

            $this->replyWithMessage(['text' => 'Done']);
        } catch (\Exception $exception) {
            $this->replyWithMessage(['text' => "Oops. Something is wrong. {$exception->getMessage()}"]);
        }
    }
}