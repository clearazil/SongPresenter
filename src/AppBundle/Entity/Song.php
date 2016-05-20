<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="songs")
 */
class Song
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var [type]
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="SongGroup", inversedBy="songs")
     * @ORM\JoinColumn(name="song_group_id", referencedColumnName="id")
     * @var [type]
     */
    private $song_group;

    /**
     * @ORM\OneToMany(targetEntity="SongVerse", mappedBy="song")
     * @var [type]
     */
    private $verses;

    /**
     * @ORM\Column(type="integer")
     * @var [type]
     */
    private $song_no;

    /**
     * @ORM\Column(type="text")
     * @var [type]
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @var [type]
     */
    private $lang;

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
     * Set title
     *
     * @param string $title
     *
     * @return Song
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return Song
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Song
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
     * @return Song
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
     * Set songGroup
     *
     * @param \AppBundle\Entity\SongGroup $songGroup
     *
     * @return Song
     */
    public function setSongGroup(\AppBundle\Entity\SongGroup $songGroup = null)
    {
        $this->song_group = $songGroup;

        return $this;
    }

    /**
     * Get songGroup
     *
     * @return \AppBundle\Entity\SongGroup
     */
    public function getSongGroup()
    {
        return $this->song_group;
    }

    /**
     * Add verse
     *
     * @param \AppBundle\Entity\SongVerse $verse
     *
     * @return Song
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

    /**
     * Set songNo
     *
     * @param integer $songNo
     *
     * @return Song
     */
    public function setSongNo($songNo)
    {
        $this->song_no = $songNo;

        return $this;
    }

    /**
     * Get songNo
     *
     * @return integer
     */
    public function getSongNo()
    {
        return $this->song_no;
    }
}
