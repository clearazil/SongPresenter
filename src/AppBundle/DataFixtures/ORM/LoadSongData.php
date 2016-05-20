<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Song;
use AppBundle\Entity\SongGroup;
use AppBundle\Entity\SongVerse;

class LoadSongData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $file = fopen(__DIR__ . '/../CSV/SongInfo.csv', 'r') or die('Unable to open file!');

        $this->loadCsvData($file, $manager);

        $file = fopen(__DIR__ . '/../CSV/SongInfoPriv.csv', 'r') or die('Unable to open file!');

        $this->loadCsvData($file, $manager);
    }

    public function loadCsvData($file, $manager) 
    {
        $songGroups = [
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

        $previousSongNo = null;
        $previousGroupNo = null;

        while($data = fgetcsv($file, 1000, ';', '"')) {
            $songGroup = $data[3];
            $songNo = $data[2];
            $songTitle = $data[0];

            if(isset($songGroups[$songGroup])) {
                if(!($previousGroupNo == $songGroup && $previousSongNo == $songNo)) {
                    if($previousGroupNo != $songGroup) {
                        $group = $manager->getRepository('AppBundle:SongGroup')
                            ->find($songGroups[$songGroup]['id']);
                    }

                    $song = new Song();

                    $song->setSongNo($songNo);
                    $song->setTitle($songTitle);
                    $song->setLang('nl');
                    $song->setSongGroup($group);
                    $manager->persist($song);
                }

                $previousSongNo = $songNo;
                $previousGroupNo = $songGroup;
            }
        } 

        $manager->flush();
        $manager->clear();        
    }

    public function getOrder()
    {
        return 2;
    }
}