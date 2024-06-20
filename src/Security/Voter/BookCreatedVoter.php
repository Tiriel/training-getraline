<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class BookCreatedVoter implements VoterInterface
{
    public const CREATED = 'book.created';

    /**
     * @inheritDoc
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $user = $token->getUser();
        if (
            array_pop($attributes) !== self::CREATED
            || !$subject instanceof Book
            || !$user instanceof User
        ) {
            return self::ACCESS_ABSTAIN;
        }

        return $user === $subject->getCreatedBy()
            ? self::ACCESS_GRANTED
            : self::ACCESS_DENIED;
    }
}
