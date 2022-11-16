<?php

namespace App\Services;

use App\Contracts\RandomCoffee as RandomCoffeeContract;
use App\Exceptions\AppException;
use App\Models\RandomCoffeeChat;
use App\Models\RandomCoffeeChatMember;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

final class TelegramRandomCoffee implements RandomCoffeeContract
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
        $chat = $chat instanceof RandomCoffeeChat
            ? $chat
            : $this->findChat($chat);

        $memberAlreadyInChat = $chat->members()
            ->where('ext_id', '=', $extId)
            ->exists();

        if ($memberAlreadyInChat) {
            throw new AppException('Member with such id already exists');
        }

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
     * @param int|string|RandomCoffeeChat $chat
     * @param int|string|RandomCoffeeChatMember $member
     * @return void
     * @throws AppException
     */
    public function removeMember($chat, $member): void
    {
        $chat = $chat instanceof RandomCoffeeChat
            ? $chat
            : $this->findChat($chat);

        $member = $member instanceof RandomCoffeeChatMember
            ? $member
            : $this->findChatMember($member);

        if ($chat->id !== $member->random_coffee_chat_id) {
            throw new AppException('Member does not belong to chat');
        }

        try {
            $member->delete();
        } catch (\Exception) {
            throw new AppException('Failed to delete chat member');
        }
    }

    /**
     * @param $chat
     * @return void
     * @throws AppException
     */
    public function sendRandomCoffeeListToChat($chat): void
    {
        $chat = $chat instanceof RandomCoffeeChat
            ? $chat
            : $this->findChat($chat);

        $pairs = $this->generatePairs($chat);

        $response = "Coffee pairs:\n";
        foreach ($pairs as $pair) {
            $pairNames = [];
            /** @var RandomCoffeeChatMember $member */
            foreach ($pair as $member) {
                $pairNames[] = $member->name;
            }
            $response .= implode(' and ', $pairNames) . "\n";
        }

        try {
            Telegram::bot('coffee')
                ->sendMessage([
                    'chat_id' => $chat->ext_id,
                    'text' => $response
                ]);
        } catch (TelegramSDKException) {
            throw new AppException('Failed to send random coffee list');
        }
    }

    /**
     * @param $id
     * @return RandomCoffeeChat
     * @throws AppException
     */
    private function findChat($id): RandomCoffeeChat
    {
        $chat = RandomCoffeeChat::query()
            ->where('id', '=', $id)
            ->orWhere(function ($query) use ($id) {
                $query
                    ->where('ext_id', '=', $id)
                    ->where('type', '=', 'telegram');
            })
            ->get()
            ->first();

        if (!$chat) {
            throw new AppException('Chat not found');
        }

        return $chat;
    }

    /**
     * @param $id
     * @return RandomCoffeeChatMember
     * @throws AppException
     */
    private function findChatMember($id): RandomCoffeeChatMember
    {
        $member = RandomCoffeeChatMember::query()
            ->where('id', '=', $id)
            ->orWhere('ext_id', '=', $id)
            ->get()
            ->first();

        if (!$id) {
            throw new AppException('Member not found');
        }

        return $member;
    }

    /**
     * @param $chat
     * @return array
     * @throws AppException
     */
    private function generatePairs($chat): array
    {
        $pairs = [];

        $members = $chat->members->all();

        if (count($members) < 2) {
            throw new AppException('Not enough members');
        }

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