<?php

namespace App\Contracts;

interface RandomCoffee
{
    public function registerChat($extId, $title);
    public function registerMember($extId, $name, $chat);
    public function removeMember($member);
    public function generatePairs($chat);
}