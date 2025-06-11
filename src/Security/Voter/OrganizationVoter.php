<?php

namespace App\Security\Voter;

use App\Entity\Organization;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class OrganizationVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const CREATE = 'create';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($subject instanceof Organization && in_array($attribute, [self::EDIT, self::VIEW])) {
            return true;
        }

        if (self::CREATE === $attribute && Organization::class === $subject) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::EDIT, self::VIEW, self::CREATE => true,
            default => false,
        };
    }
}
