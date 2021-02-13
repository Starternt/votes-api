<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Security
 */
class UserValidator implements UserCheckerInterface
{
    /**
     * @param UserInterface $user
     *
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (User::STATUS_DELETED === $user->getStatus()) {
            throw new LockedException('Your account has been deleted');
        }
    }

    /**
     * @param UserInterface $user
     *
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (User::STATUS_OFF === $user->getStatus()) {
            throw new DisabledException('Your account has been blocked');
        }
    }
}