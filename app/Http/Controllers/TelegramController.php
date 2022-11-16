<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook(string $token): Response
    {
        if ($token !== config('telegram.webhook_token')) {
            return new Response(status: 404);
        }

        Telegram::commandsHandler(true);

        return new Response('ok');
    }
}
