<?php

namespace CoreDomain\Repository\User;

use CoreDomain\Model\User\UserSession;

interface UserSessionRepositoryInterface
{
    /**
     * @return \CoreDomain\Model\User\UserSession
     */
    public function findOneByToken($token);

    public function addAndSave(UserSession $session);
}