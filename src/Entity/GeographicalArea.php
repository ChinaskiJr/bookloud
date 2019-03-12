<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class GeographicalArea
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="bookloud_GeographicalArea")
 * @UniqueEntity("geographicalArea", message="This area is already in the database.")
 */
class GeographicalArea {
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
     * @Assert\NotBlank(message = "Pourquoi une zone vide ?")
     */
    private $geographicalArea;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="geographicalArea", cascade={"persist"})
     * @ORM\JoinTable(name="bookloud_book_geographicalArea"))
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
    public function getGeographicalArea() {
        return $this->geographicalArea;
    }

    /**
     * @param string $geographicalArea
     */
    public function setGeographicalArea(string $geographicalArea) {
        $this->geographicalArea = $geographicalArea;
    }

    /**
     * @return ArrayCollection
     */
    public function getBooks() {
        return $this->books;
    }

    /**
     * @param ArrayCollection $books
     */
    public function setBooks(ArrayCollection $books) {
        $this->books = $books;
    }

    /**
     * @param Book $book
     * @return GeographicalArea
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
     * @return GeographicalArea
     */
    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
        }

        return $this;
    }
}