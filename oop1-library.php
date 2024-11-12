<?php

abstract class Book
{
    public const PERDAYFINE = self::PERDAYFINE;
    public const BORROWDAYSPAN = self::BORROWDAYSPAN;

    protected string $title;
    protected string $author;

    protected function __construct(string $name, string $author)
    {
        $this->title = $name;
        $this->author = $author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    abstract public function borrow(): void;
    abstract public function return(): int;
}

class PrintedBook extends Book
{
    public const PERDAYFINE = 20;
    public const BORROWDAYSPAN = 14;

    private DateTime $returnDate;
    private bool $occupied;

    public function __construct(string $title, string $author)
    {
        parent::__construct($title, $author);
        $this->occupied = false;
    }

    public function isOccupied(): bool
    {
        return $this->occupied;
    }

    public function borrow(): void
    {
        $this->returnDate = date_add(new DateTime(), date_interval_create_from_date_string($this::BORROWDAYSPAN . ' days'));
        $this->occupied = true;
    }

    public function return(): int
    {
        $diff_date = (new DateTime())->diff($this->returnDate)->format("%r%a");
        $this->occupied = false;

        if ($diff_date < 0) {
            return $this::PERDAYFINE * $diff_date * -1;
        }

        return 0;
    }
}

class EBook extends Book
{
    public const PERDAYFINE = 10;
    public const BORROWDAYSPAN = 7;

    public function __construct(string $title, string $author)
    {
        parent::__construct($title, $author);
    }

    public function borrow(): void
    {
        print("Generating a random link for accessing {$this->getTitle()}. Which expires in 7 days.\n");
        $link = str_shuffle("abcd%e2103f%ghi_j");
        print("https://bookpedia.com/{$link}\n");
    }

    public function return(): int
    {
        return 0;
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

    public function getName(): string
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

    public function addBook(Book $book): void
    {
        array_push($this->books, $book);
    }

    public function borrowBook(Member $member, string $bookTitle): void
    {
        $book = $this->findBook($bookTitle);
        if ($book == null) {
            print "Book not found";
            return;
        }

        array_push($this->borrowers, $member);
        $book->borrow();

        $borrowDaySpan = $book::BORROWDAYSPAN;
        print("{$member->getName()} has borrowed {$book->getTitle()}. Due in {$borrowDaySpan} days\n");
    }

    public function returnBook(Member $member, string $bookTitle): void
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
        print("{$member->getName()} has returned {$book->getTitle()}");

        $fine = $book->return();
        if ($fine === 0) {
            print(" with no fine.\n");
        } else {
            array_push($this->loans, [$member, $fine]);
            print(" with {$fine} TAKA FINE\n");
        }
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

sleep(2);

$library->returnBook($member, "1984");
