<?php

namespace CoreDomain\Infrastructure\Mail;

use CoreDomain\Model\User\Password;
use CoreDomain\Model\User\User;

interface MessengerInterface
{
    public function sendResettingEmailMessage(User $user, Password $password);
    public function flush();
}
