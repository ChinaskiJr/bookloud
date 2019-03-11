<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Epoch
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="bookloud_epoch")
 * @UniqueEntity("epoch", message="This epoch is already in the database.")
 */
class Epoch {
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message = "Pourquoi une époque vide ?")
     */
    private $epoch;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="epoch")
     * @ORM\JoinTable(name="bookloud_book_epoch"))
     */
    private $books;

    public function __construct() {
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
    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEpoch() {
        return $this->epoch;
    }

    /**
     * @param string $epoch
     */
    public function setEpoch(string $epoch) {
        $this->epoch = $epoch;
    }
    /**
     * @return ArrayCollection
     */
    public function getBooks(): ArrayCollection {
        return $this->books;
    }

    /**
     * @param ArrayCollection $books
     */
    public function setBooks(ArrayCollection $books): void {
        $this->books = $books;
    }
    /**
     * @param Book $book
     * @return Epoch
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
     * @return Epoch
     */
    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
        }

        return $this;
    }
}