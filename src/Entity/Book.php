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

class Book {
    /**
     * @var integer
     * @Assert\Regex(
     *     pattern="/\d{13}/",
     *     message="L'ISBN c'est 13 chiffres."
     * )
     */
    private $isbn;
    /**
     * @var string
     * @Assert\NotBlank(message = "Le titre, c'est obligatoire.")
     */
    private $title;
    /**
     * @var string
     * @Assert\NotBlank(message = "L'éditeur c'est obligatoire")
     */
    private $editor;
    /**
     * @var mixed
     */
    private $keywords;

    /**
     * Book constructor.
     * @param int $isbn
     * @param string $title
     * @param string $editor
     * @param mixed $keywords
     */
    public function __construct($isbn = null, $title = null, $editor = null, $keywords = null) {
        $this->setIsbn($isbn);
        $this->setTitle($title);
        $this->setEditor($editor);
        $this->setKeywords($keywords);
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
     * @return mixed
     */
    public function getKeywords(){
        return $this->keywords;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords) {
        $this->keywords =   is_null($keywords) ? new ArrayCollection() : new ArrayCollection($keywords);
    }


}