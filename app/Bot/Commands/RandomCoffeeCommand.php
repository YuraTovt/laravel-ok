<?php

namespace App\Bot\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use App\Models\RandomCoffeeChatMember;
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
            $chat = RandomCoffeeChat::query()
                ->where('ext_id', '=', $telegramChat->id)
                ->where('type', '=', 'telegram')
                ->get()
                ->first();

            $pairs = $this->randomCoffee->generatePairs($chat);

            $response = "Coffee pairs:\n";
            foreach ($pairs as $pair) {
                $pairNames = [];
                /** @var RandomCoffeeChatMember $member */
                foreach ($pair as $member) {
                    $pairNames[] = $member->name;
                }
                $response .= implode(' and ', $pairNames) . "\n";
            }

            $this->replyWithMessage(['text' => $response]);
        } catch (\Exception $exception) {
            $this->replyWithMessage(['text' => "Oops. Something is wrong. {$exception->getMessage()}"]);
        }
    }
}