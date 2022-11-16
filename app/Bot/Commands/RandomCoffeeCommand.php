<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use Telegram\Bot\Commands\Command;

class RandomCoffeeCommand extends Command
{
    protected $name = 'coffee';
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

        try {
            $this->randomCoffee->sendRandomCoffeeListToChat(
                $telegramChat->id
            );
        } catch (\Exception $exception) {
            $this->replyWithMessage(['text' => "Oops. Something is wrong. {$exception->getMessage()}"]);
        }
    }
}