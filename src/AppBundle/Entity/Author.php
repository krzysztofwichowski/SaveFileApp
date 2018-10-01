<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Upload;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Author
 *
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity="Upload", mappedBy="aid")
     */
    protected $upload;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Author
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Author
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    public function __construct()
    {
        $this->upload = new ArrayCollection();
    }

    /**
     * Add upload
     *
     * @param Upload $upload
     *
     * @return Author
     */
    public function addUpload(Upload $upload)
    {
        $this->upload[] = $upload;

        return $this;
    }

    /**
     * Remove upload
     *
     * @param Upload $upload
     */
    public function removeUpload(Upload $upload)
    {
        $this->upload->removeElement($upload);
    }

    /**
     * Get upload
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUpload()
    {
        return $this->upload;
    }
}

