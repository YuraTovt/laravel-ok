<?php

namespace App\Services;

use App\Contracts\RandomCoffee as RandomCoffeeContract;
use App\Exceptions\AppException;
use App\Models\RandomCoffeeChat;
use App\Models\RandomCoffeeChatMember;

class TelegramRandomCoffee implements RandomCoffeeContract
{
    /**
     * @param $extId
     * @param $title
     * @return RandomCoffeeChat
     * @throws AppException
     */
    public function registerChat($extId, $title): RandomCoffeeChat
    {
        $chat = new RandomCoffeeChat();

        $chat->ext_id = $extId;
        $chat->type = 'telegram';
        $chat->title = $title;

        try {
            $chat->save();
        } catch (\Exception) {
            throw new AppException('Failed to save chat data');
        }

        return $chat;
    }

    /**
     * @param $extId
     * @param $name
     * @param $chat
     * @return RandomCoffeeChatMember
     * @throws AppException
     */
    public function registerMember($extId, $name, $chat): RandomCoffeeChatMember
    {
        $member = new RandomCoffeeChatMember();

        $member->ext_id = $extId;
        $member->name = $name;
        $member->chat()->associate($chat);

        try {
            $member->save();
        } catch (\Exception) {
            throw new AppException('Failed to add member to chat');
        }

        return $member;
    }

    /**
     * @param RandomCoffeeChatMember $member
     * @return void
     * @throws AppException
     */
    public function removeMember($member): void
    {
        try {
            $member->delete();
        } catch (\Exception) {
            throw new AppException('Failed to delete chat member');
        }
    }

    /**
     * @param $chat
     * @return array
     */
    public function generatePairs($chat): array
    {
        $pairs = [];

        $members = $chat->members->all();

        shuffle($members);

        while (count($members)) {
            $pair = [];
            $pair[] = array_pop($members);
            $pair[] = array_pop($members);

            if (count($members) === 1) {
                $pair[] = array_pop($members);
            }

            $pairs[] = $pair;
        }

        return $pairs;
    }
}