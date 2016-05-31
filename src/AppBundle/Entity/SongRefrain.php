<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="song_refrains")
 */
class SongRefrain
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var [type]
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="SongVerse", mappedBy="refrain")
     * @var [type]
     */
    private $verses;

    /**
     * @ORM\Column(type="text")
     * @var [type]
     */
    private $refrain;
    
    /**
     * @ORM\Column(type="datetime")
     * @var [type]
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @var [type]
     */
    private $updated_at;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return [type] [description]
     */
    public function updateTimestamps()
    {
        $this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->verses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set refrain
     *
     * @param string $refrain
     *
     * @return SongRefrain
     */
    public function setRefrain($refrain)
    {
        $this->refrain = $refrain;

        return $this;
    }

    /**
     * Get refrain
     *
     * @return string
     */
    public function getRefrain()
    {
        return $this->refrain;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SongRefrain
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return SongRefrain
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add verse
     *
     * @param \AppBundle\Entity\SongVerse $verse
     *
     * @return SongRefrain
     */
    public function addVerse(\AppBundle\Entity\SongVerse $verse)
    {
        $this->verses[] = $verse;

        return $this;
    }

    /**
     * Remove verse
     *
     * @param \AppBundle\Entity\SongVerse $verse
     */
    public function removeVerse(\AppBundle\Entity\SongVerse $verse)
    {
        $this->verses->removeElement($verse);
    }

    /**
     * Get verses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVerses()
    {
        return $this->verses;
    }
}
