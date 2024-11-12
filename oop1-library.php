<?php

abstract class Book
{
    public const PERDAYFINE = self::PERDAYFINE;

    public bool $occupied;

    protected string $title;
    protected string $author;

    protected function __construct(string $name, string $author)
    {
        $this->title = $name;
        $this->author = $author;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

class PrintedBook extends Book
{
    public const PERDAYFINE = 20;

    public function __construct(string $title, string $author)
    {
        parent::__construct($title, $author);
        $this->occupied = false;
    }
}

class EBook extends Book
{
    public const PERDAYFINE = 10;
    public function __construct(string $title, string $author)
    {
        parent::__construct($title, $author);
    }
}

class Member
{
    private string $name;
    private string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Library
{
    private array $books;
    private array $borrowers;
    private array $loans;

    public function __construct()
    {
        $this->books = [];
        $this->borrowers = [];
        $this->loans = [];
    }

    public function addBook(Book $book)
    {
        array_push($this->books, $book);
    }

    public function borrowBook(Member $member, string $bookTitle)
    {
        $book = $this->findBook($bookTitle);
        if ($book == null) {
            print "Book not found";
            return;
        }


        array_push($this->borrowers, $member);
        $book->occupied = true;
        print("{$member->getName()} has borrowed {$book->getTitle()}. Due in 14 days\n");
    }

    public function returnBook(Member $member, string $bookTitle)
    {
        $book = $this->findBook($bookTitle);

        if ($book == null) {
            print("Book not found\n");
            return;
        }

        $borrowerIndex = $this->findBorrower($member);

        if ($borrowerIndex == -1) {
            print("This member did not borrow\n");
            return;
        }

        array_splice($this->borrowers, $borrowerIndex, 1);
        print("{$member->getName()} has returned {$book->getTitle()}.\n");

        $book->occupied = false;
    }

    private function findBorrower(Member $member): int
    {
        for ($i = 0; $i < count($this->borrowers); $i++) {
            if ($member === $this->borrowers[$i]) {
                return $i;
            }
        }
        return -1;
    }

    private function findBook(string $bookTitle): Book
    {
        foreach ($this->books as $book) {
            if ($book->getTitle() == $bookTitle) {
                return $book;
            }
        }
        return null;
    }
}

$library = new Library();

$book = new PrintedBook("1984", "George Orwell");
$library->addBook($book);
$member = new Member("Alice", "alice@example.com");

$library->borrowBook($member, "1984");

$library->returnBook($member, "1984");
