<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        $faker = Factory::create('FR-fr');
        
        //Nous gerons les utilisateurs
        $users = [];
        $genres = ['male', 'female'];

        for($i = 1; $i <=10; $i++){
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .=  ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $user->setFirstName($faker->firstname($genre))
            ->setLastName($faker->lastname)
            ->setEmail($faker->email)
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)). '</p>')
            ->setPwd('password')
            ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }

        //Nous gerons les annonces
        for($i = 1; $i <= 30; $i++){
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)). '</p>';

            $user = $users[mt_rand(0, count($users) - 1)];


            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40000, 200000))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);

            for($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setAd($ad);

                $manager->persist($image);

            }

        $manager->persist($ad);

        }

        $manager->flush();
    }
}
