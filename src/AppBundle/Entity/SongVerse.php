<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="song_verses")
 */
class SongVerse
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var [type]
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Song", inversedBy="songverses")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     * @var [type]
     */
    private $song;

    /**
     * @ORM\ManyToOne(targetEntity="SongRefrain", inversedBy="songverses")
     * @ORM\JoinColumn(name="refrain_id", referencedColumnName="id")
     * @var [type]
     */
    private $refrain;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     * @var [type]
     */
    private $verse_no;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     * @var [type]
     */
    private $verse;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set verseNo
     *
     * @param integer $verseNo
     *
     * @return SongVerse
     */
    public function setVerseNo($verseNo)
    {
        $this->verse_no = $verseNo;

        return $this;
    }

    /**
     * Get verseNo
     *
     * @return integer
     */
    public function getVerseNo()
    {
        return $this->verse_no;
    }

    /**
     * Set verse
     *
     * @param string $verse
     *
     * @return SongVerse
     */
    public function setVerse($verse)
    {
        $this->verse = $verse;

        return $this;
    }

    /**
     * Get verse
     *
     * @return string
     */
    public function getVerse()
    {
        return $this->verse;
    }

    public function addSong(Song $song)
    {
        $this->setSong($song);

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SongVerse
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
     * @return SongVerse
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
     * Set song
     *
     * @param \AppBundle\Entity\Song $song
     *
     * @return SongVerse
     */
    public function setSong(\AppBundle\Entity\Song $song = null)
    {
        $this->song = $song;

        return $this;
    }

    /**
     * Get song
     *
     * @return \AppBundle\Entity\Song
     */
    public function getSong()
    {
        return $this->song;
    }

    /**
     * Set refrain
     *
     * @param \AppBundle\Entity\SongRefrain $refrain
     *
     * @return SongVerse
     */
    public function setRefrain(\AppBundle\Entity\SongRefrain $refrain = null)
    {
        $this->refrain = $refrain;

        return $this;
    }

    /**
     * Get refrain
     *
     * @return \AppBundle\Entity\SongRefrain
     */
    public function getRefrain()
    {
        return $this->refrain;
    }
}
