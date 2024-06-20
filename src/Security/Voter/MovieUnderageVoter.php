<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class MovieUnderageVoter implements VoterInterface
{
    public const UNDERAGE = 'movie.underage';

    /**
     * @inheritDoc
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $user = $token->getUser();

        if (
            !$user instanceof User
            || !$subject instanceof Movie
            || \array_pop($attributes) !== self::UNDERAGE
        ) {
            return self::ACCESS_ABSTAIN;
        }

        $vote = match ($subject->getRated()) {
            'G' => true,
            'PG', 'PG-13' => $user->getAge() && $user->getAge() >= 13,
            'R', 'NC-17' => $user->getAge() && $user->getAge() >= 17,
            default => false,
        };

        return $vote ? self::ACCESS_GRANTED : self::ACCESS_DENIED;
    }
}
