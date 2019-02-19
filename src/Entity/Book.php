<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 17:54
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Book
 * @ORM\Entity()
 * @ORM\Table(name="bookloud_book")
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
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\Keyword", mappedBy="books")
     * @ORM\JoinTable(name="bookloud_keyword"))
     */
    private $keywords;

    /**
     * Book constructor.
     * @param int $id
     * @param int $isbn
     * @param string $title
     * @param string $editor
     * @param null|array $keywords
     */
    public function __construct($id = null, $isbn = null, $title = null, $editor = null, $keywords = null) {
        $this->setId($id);
        $this->setIsbn($isbn);
        $this->setTitle($title);
        $this->setEditor($editor);
        $this->setKeywords($keywords);
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
     * @return array
     */
    public function getKeywords(){
        return $this->keywords;
    }

    /**
     * @param null|array $keywords
     */
    public function setKeywords($keywords) {
        $this->keywords =  is_null($keywords) ? new ArrayCollection() : new ArrayCollection($keywords);
    }


}