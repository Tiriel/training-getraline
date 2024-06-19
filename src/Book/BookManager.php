<?php

namespace App\Book;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Mailer\MailerInterface;

class BookManager
{
    public function __construct(
        protected readonly BookRepository $repository,
        protected readonly MailerInterface $mailer,
        protected readonly int $limit,
    )
    {
    }

    public function findByTitle(string $title): ?Book
    {
        return $this->repository->findOneBy(['title' => $title]);
    }

    public function getPaginated(int $page): iterable
    {
        return $this->repository->findBy([], ['id' => 'DESC'], $this->limit, $this->limit * ($page - 1));
    }
}
