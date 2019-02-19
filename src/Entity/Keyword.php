<?php
/**
 * Created by PhpStorm.
 * User: chinaskijr
 * Date: 17/02/19
 * Time: 19:23
 */

namespace App\Entity;

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
     * @var array
     */
    private $books;

    /**
     * Keyword constructor.
     * @param int $id
     * @param string $name
     * @param $books
     */
    public function __construct($id = null, $name = null, $books = null) {
        $this->setId($id);
        $this->setName($name);
        $this->setBooks($books);
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