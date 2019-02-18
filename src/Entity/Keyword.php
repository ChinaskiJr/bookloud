<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 19:23
 */

namespace App\Entity;


class Keyword {
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $books;

    /**
     * Keyword constructor.
     * @param $name
     * @param $books
     */
    public function __construct($name = null, $books = null) {
        $this->setName($name);
        $this->setBooks($books);
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBooks() {
        return $this->books;
    }

    /**
     * @param mixed $books
     */
    public function setBooks($books): void {
        $this->books = $books;
    }
}