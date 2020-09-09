<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i<6; $i++) {

            $user  = new User();
            $user->setEmail($faker->email);
            $user->setUsername($faker->userName);
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
                  
            $manager->persist($user);
        }

        for($i=0; $i<20; $i++){
            $task  = new Task();
            $task->setTitle('Tache : '. $i);
            $task->setContent($faker->text(200));
            $task->setCreatedAt($faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'));
            $task->isDone($faker->boolean());
            $manager->persist($task);
        }
        $manager->flush();
    }
}
