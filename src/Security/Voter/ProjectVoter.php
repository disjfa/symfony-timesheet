<?php

namespace App\Security\Voter;

use App\Entity\Project;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ProjectVoter extends Voter
{
    public const CREATE = 'create';
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const VIEW_ANY = 'view_any';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($subject instanceof Project && in_array($attribute, [self::EDIT, self::VIEW])) {
            return true;
        }

        if (Project::class === $subject && in_array($attribute, [self::CREATE, self::VIEW_ANY])) {
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

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case self::VIEW_ANY:
                // logic to determine if the user can VIEW_ANY
                // return true or false
                break;
        }

        return false;
    }
}
