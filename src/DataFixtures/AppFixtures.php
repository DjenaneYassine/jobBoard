<?php

namespace App\DataFixtures;

use App\Entity\Offre;
use App\Entity\Service;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const TAGS = ['PHP', 'SYMFONY', 'LARAVEL', 'JS', 'REACT', 'VUE', 'ANGULAR', 'SQL'];
    private const SERVICES = ['MARKETING', 'DESIGN', 'DEVELOPMENT', 'SALES', 'ACCOUNTING', 'HR'];

    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

        foreach(self::TAGS as $tagName){
            $manager->persist($this->createTag($tagName));
        }

        foreach(self::SERVICES as $service){
            $manager->persist($this->createServices(
                $service,
                $faker->phoneNumber(),
                $faker->email()
                )
            );
        }

        $manager->flush();

        for($i=0; $i < 25; $i++){
            $offre = $this->createOffre(
                $faker->jobTitle(),
                $faker->paragraph(3),
                $faker->randomFloat(6,0,9999),
                $this->randomService($manager),
                $this->randomSTag($manager)
            );

            $manager->persist($offre);
        }

        $manager->flush();
    }

    private function createServices(string $nom, string $telephone, string $email): Service
    {
        $service = new Service();
        $service
            ->setNom($nom)
            ->setTelephone($telephone)
            ->setEmail($email)
        ;

        return $service;
    }

    private function createTag(string $nom): Tag
    {
        $tag = new Tag();
        $tag->setNom($nom);

        return $tag;
    }

    private function createOffre(string $nom, string $desc, float $salaire, Service $service, array $tags): Offre
    {
        $offre = new Offre();

        $offre
            ->setNom($nom)
            ->setDescription($desc)
            ->setSalaire($salaire)
            ->setService($service)
        ;

        foreach($tags as $tag){
            $offre->addTag($tag);
        }

        return $offre;
    }

    private function randomService(ObjectManager $manager): Service
    {
        return $manager->getRepository(Service::class)->findByNom(self::SERVICES[array_rand(self::SERVICES)])[0];
    }

    private function randomSTag(ObjectManager $manager): array
    {
        $tags = [];
        
        for($i=0; $i < 3; $i++){
            $tags[] = $manager->getRepository(Tag::class)->findByNom(self::TAGS[array_rand(self::TAGS)])[0];
        }

        return $tags;
    }
}
