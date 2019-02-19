<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 19:23
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Keyword
 * @ORM\Entity()
 * @ORM\Table(name="bookloud_kewyord")
 */
class Keyword {
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $name;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="keywords")
     * @ORM\JoinTable(name="bookloud_book_keyword"))
     */
    private $books;

    /**
     * Keyword constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getBooks() {
        return $this->books;
    }

    /**
     * @param Book $book
     * @return Keyword
     */
    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
        }

        return $this;
    }

    /**
     * @param Book $book
     * @return Keyword
     */
    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
        }

        return $this;
    }
}