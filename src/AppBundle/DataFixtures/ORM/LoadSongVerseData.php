<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\SongVerse;


class LoadSongVerseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
       $file = fopen(__DIR__ . '/../CSV/SongData.csv', 'r') or die('Unable to open file!');

       $this->loadCsvData($file, $manager);

       $file = fopen(__DIR__ . '/../CSV/SongDataPriv.csv', 'r') or die('Unable to open file!');

       $this->loadCsvData($file, $manager);
    }

    public function loadCsvData($file, $manager)
    {
        $songGroupDatas = [
            1 => [
                'id' => '1',
            ],
            2 => [
                'id' => '2',
            ],
            3 => [
                'id' => '3',
            ],
            5 => [
                'id' => '4',
            ],
            8 => [
                'id' => '5',
            ],
            9 => [
                'id' => '6',
            ],
            10 => [
                'id' => '7',
            ],
            16 => [
                'id' => '8',
            ],
            103 => [
                'id' => '9',
            ],
            104 => [
                'id' => '10',
            ],
            106 => [
                'id' => '11',
            ],
            107 => [
                'id' => '12',
            ],
            108 => [
                'id' => '13',
            ],
        ];

        $previousVerseNo = null;
        $previousSongNo = null;
        $previousSongGroup = null;

        $verse = null;
        $verseData = '';
 
        while($data = fgetcsv($file, 1000, ';', '"')) {
            $songGroup = $data[0];
            $songNo = $data[1];
            $verseNo = $data[2];
            $verseRow = $data[4];

            if(isset($songGroupDatas[$songGroup])) {
                if(!($previousVerseNo == $verseNo && $previousSongNo == $songNo)) {
                    if($verse instanceof SongVerse) {
                        $song = $manager->getRepository('AppBundle:Song')
                            ->findOneBy([
                                'song_group' => $songGroupDatas[$previousSongGroup]['id'],
                                'song_no'       => $previousSongNo,
                        ]);

                        if(!is_null($song)) {
                            $verse->setVerseNo($previousVerseNo);
                            $verse->setVerse($verseData);
                            $verse->setSong($song);
                            $manager->persist($verse);                 
                        }
                    }

                    $verse = new SongVerse;
                    
                    $verseData = $verseRow;
                } else {
                    $verseData .= ';endl;' . $verseRow;
                }

                $previousVerseNo = $verseNo;
                $previousSongNo = $songNo;
                $previousSongGroup = $songGroup;
            }
        }

        $manager->flush();
        $manager->clear();       
    }

    public function getOrder()
    {
        return 3;
    }
}