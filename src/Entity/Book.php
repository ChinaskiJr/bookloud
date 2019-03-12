<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 17:54
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Book
 * @ORM\Entity()
 * @ORM\Table(name="bookloud_book")
 * @UniqueEntity("isbn", message="This book is already in the database.")
 * @UniqueEntity("title", message="This book is already in the database.")
 */
class Book {
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", length=13, unique=true)
     * @Assert\Regex(
     *     pattern="/\d{13}/",
     *     message="L'ISBN c'est 13 chiffres."
     * )
     */
    private $isbn;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Le titre, c'est obligatoire.")
     */
    private $title;
    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "L'éditeur c'est obligatoire")
     */
    private $editor;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Keyword", mappedBy="books", cascade={"persist"})
     * @ORM\JoinTable(name="bookloud_book_keyword")
     * @Assert\Valid
     */
    private $keywords;
    /**
     * @var Epoch
     * @ORM\ManyToOne(targetEntity="App\Entity\Epoch", inversedBy="books", cascade={"persist"})
     * @ORM\JoinTable(name="bookloud_book_epoch")
     */
    private $epoch;
    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="App\Entity\GeographicalArea", inversedBy="books", cascade={"persist"})
     * @ORM\JoinTable(name="bookloud_book_geographicalArea")
     */
    private $geographicalArea;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->epoch = new Epoch();
        $this->geographicalArea = new GeographicalArea();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    /**
     * @return int
     */
    public function getIsbn() {
        return $this->isbn;
    }

    /**
     * @param int $isbn
     */
    public function setIsbn($isbn) {
        $this->isbn = $isbn;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getEditor() {
        return $this->editor;
    }

    /**
     * @param string $editor
     */
    public function setEditor($editor) {
        $this->editor = $editor;
    }

    /**
     * @return ArrayCollection
     */
    public function getKeywords(){
        return $this->keywords;
    }

    /**
     * @param Keyword $keyword
     * @return Book
     */
    public function addKeyword(Keyword $keyword)
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
            $keyword->addBook($this);
        }

        return $this;
    }

    /**
     * @param Keyword $keyword
     * @return Book
     */
    public function removeKeyword(Keyword $keyword)
    {
        if ($this->keywords->contains($keyword)) {
            $this->keywords->removeElement($keyword);
            $keyword->removeBook($this);
        }

        return $this;
    }
    /**
     * @return Epoch
     */
    public function getEpoch() {
        return $this->epoch;
    }

    /**
     * @param Epoch $epoch
     */
    public function setEpoch(Epoch $epoch) {
        $this->epoch = $epoch;
    }

    /**
     * @return ArrayCollection
     */
    public function getGeographicalArea() {
        return $this->geographicalArea;
    }

    /**
     * @param GeographicalArea $geographicalArea
     */
    public function setGeographicalArea(GeographicalArea $geographicalArea) {
        $this->geographicalArea = $geographicalArea;
    }
}