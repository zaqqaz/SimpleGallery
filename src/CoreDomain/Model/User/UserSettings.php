<?php

namespace CoreDomain\Model\User;

class UserSettings
{
    private $id;

    private $language;
    private $wordRepetitionType;
    private $allowEmailWordRepetitionNotify;
    private $allowEmailAdministrativeNotify;
    private $allowSmsWordRepetitionNotify;
    private $allowSmsAdministrativeNotify;

    private $user;
}