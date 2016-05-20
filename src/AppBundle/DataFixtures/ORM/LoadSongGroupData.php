<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\SongGroup;


class LoadSongGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $songGroupDatas = [
            1 => [
                'abbr' => 'Ps',
                'name' => 'Psalm GKV',
            ],
            2 => [
                'abbr' => 'Gez',
                'name' => 'Gezang GKV',
            ],
            3 => [
                'abbr' => 'Gez',
                'name' => 'Liedboek voor de Kerken',
            ],
            5 => [
                'abbr' => 'E&R',
                'name' => 'Elly en Rikkert',
            ],
            8 => [
                'abbr' => 'Ps',
                'name' => 'Psalm Nieuwe Berijming',
            ],
            9 => [
                'abbr' => 'Gez',
                'name' => 'Gezang',
            ],
            10 => [
                'abbr' => 'Opw',
                'name' => 'Opwekking',
            ],
            16 => [
                'abbr' => 'ELB',
                'name' => 'Evangelische Liedbundel',
            ],
            103 => [
                'abbr' => 'KND',
                'name' => 'Kinderbundel',
            ],
            104 => [
                'abbr' => 'Ps',
                'name' => 'Psalm Oude Berijming',
            ],
            106 => [
                'abbr' => 'Joh d H',
                'name' => 'Johannes de Heer',
            ],
            107 => [
                'abbr' => 'Enige Gz',
                'name' => 'Enige Gezangen',
            ],
            108 => [
                'abbr' => 'Schriftber',
                'name' => 'Schriftberijmingen',
            ],
        
        ];

        foreach($songGroupDatas as $data) {
            $songGroup = new SongGroup();

            $songGroup->setAbbreviation($data['abbr']);
            $songGroup->setName($data['name']);

            $manager->persist($songGroup);
            $manager->flush();
            $manager->clear();
        }
    }

    public function getOrder()
    {
        return 1;
    }
}