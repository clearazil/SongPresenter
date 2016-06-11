<?php

namespace AppBundle\Security;

use AppBundle\Entity\SongGroup;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SongBundleVoter extends Voter
{
    const EDIT = 'EDIT';
    const VIEW = 'VIEW';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::VIEW])) {
            return false;
        }

        if (!$subject instanceof SongGroup) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $songBundle = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($songBundle, $user);
            case self::VIEW:
                return $this->canView($token);
        }
    }

    private function canEdit($songBundle, $user)
    {
        if(in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }
    }

    private function canView($token)
    {
        if($this->decisionManager->decide($token, ['IS_AUTHENTICATED_REMEMBERED'])) {
            return true;
        }
    }
}
