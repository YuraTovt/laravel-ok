<?php

namespace App\Console\Commands;

use App\Contracts\RandomCoffee;
use App\Models\RandomCoffeeChat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RandomCoffeeCommand extends Command
{
    protected $signature = 'app:random-coffee';
    protected $description = 'Random coffee';
    protected RandomCoffee $randomCoffee;

    public function __construct(RandomCoffee $randomCoffee)
    {
        parent::__construct();
        $this->randomCoffee = $randomCoffee;
    }

    public function handle()
    {
        $chats = RandomCoffeeChat::query()->cursor();

        foreach ($chats as $chat) {
            try {
                $this->randomCoffee->sendRandomCoffeeListToChat($chat);
            } catch (\Exception $exception) {
                Log::error(
                    'Failed to send random coffee to chat',
                    ['chat_ext_id' => $chat->ext_id, 'error' => $exception->getMessage()]
                );
            }
        }

        return self::SUCCESS;
    }
}
